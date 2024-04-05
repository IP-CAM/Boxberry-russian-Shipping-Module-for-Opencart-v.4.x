<?php

namespace Opencart\Catalog\Model\Extension\Boxberry\Shipping;

use Boxberry\Client\Client;
use Exception;

if (!class_exists('Client')) {
    require_once DIR_EXTENSION . 'boxberry/system/library/boxberry/autoload.php';
}

class Boxberry extends \Opencart\System\Engine\Model
{
    public function getQuote($address): array
    {
        $quoteData = [];
        $methodData = [];
        if ($this->config->get('shipping_boxberry_status')) {
            $this->load->language('extension/boxberry/shipping/boxberry');
            $this->unsetKeys($address);

            $boxberryLengthClassId = $this->config->get('shipping_boxberry_length_class_id');
            $boxberryWeightClassId = $this->config->get('shipping_boxberry_weight_class_id');
            $boxberryWeightMin     = $this->config->get('shipping_boxberry_weight_min');
            $boxberryWeightMax     = $this->config->get('shipping_boxberry_weight_max');

            if ($cartItems = $this->cart->getProducts()) {
                foreach ($cartItems as $cartItem) {
                    $width     = (float) $this->length->convert($cartItem['width'], $cartItem['length_class_id'], $boxberryLengthClassId);
                    $height    = (float) $this->length->convert($cartItem['height'], $cartItem['length_class_id'], $boxberryLengthClassId);
                    $length    = (float) $this->length->convert($cartItem['length'], $cartItem['length_class_id'], $boxberryLengthClassId);

                    if (($width + $height + $length) > 250 || $width > 120 || $height > 120 || $length > 120) {
                        return $methodData;
                    }
                }
            }

            $weight = $this->weight->convert(
                $this->cart->getWeight(),
                $this->config->get('config_weight_class_id'),
                $boxberryWeightClassId
            );
            if (($boxberryWeightMax > 0 && ($weight > $boxberryWeightMax)) || ($boxberryWeightMin >= 0 && ($weight < $boxberryWeightMin))) {
                return $methodData;
            }

            $dimensions = $this->getFullDimensions();
            $widgetSettings  = $this->getWidgetSettings();
            $hideDeliveryDay = $widgetSettings->getHide_delivery_day();

            $shippingMethods = [
                'pickup'                   => 'shipping_boxberry_pickup_status',
                'pickup_prepaid'           => 'shipping_boxberry_pickup_prepaid_status',
                'courier_delivery'         => 'shipping_boxberry_courier_delivery_status',
                'courier_delivery_prepaid' => 'shipping_boxberry_courier_delivery_prepaid_status'
            ];

            foreach ($shippingMethods as $deliveryType => $configStatusName) {
                if ($this->config->get($configStatusName)) {
                    $data = $this->getQuoteData($deliveryType, $address, $dimensions, $hideDeliveryDay);
                    if ($data === []) {
                        continue;
                    }

                    $quoteData[$deliveryType] = $data;
                }
            }
        }

        if ($quoteData) {
            $methodData = [
                'code'       => 'boxberry',
                'name'       => $this->language->get('text_title'),
                'quote'      => $quoteData,
                'sort_order' => $this->config->get('shipping_boxberry_sort_order'),
                //'error'      => false,
            ];
        }

        return $methodData;
    }

    public function getQuoteData($deliveryType, $address, $dimensions, $hideDeliveryDay): array
    {
        if (empty(trim($address['city']))) {
            return [];
        }

        $prepaid = (false !== stripos($deliveryType, 'prepaid')) ? '1' : '0';

        if ($prepaid === '0' && !$this->isCodAvailableForCountry($address['iso_code_2'])) {
            return [];
        }

        if (!$city = $this->getBoxberryCity($address)) {
            return [];
        }

        $zip = '';

        if (isset($address['postcode']) && !empty(trim($address['postcode'])) && strlen($address['postcode']) === 6 && is_numeric($address['postcode'])) {
            $zip = $this->getZipCheck($address['postcode']);
        }

        if (!$costData = $this->getDeliveryCalculationResult($deliveryType, $city['code'], $prepaid, $dimensions, $zip)) {
            return [];
        }

        if (str_contains($deliveryType, 'pickup')) {

            if (!$costData->getPriceBasePickup()) {
                return [];
            }

            try {
                unset($this->session->data['boxberry_shipping_fail_cost_issue_point' . ($prepaid === '1' ? '_prepaid' : '')]);

                if (isset($this->session->data['boxberry_shipping_issue_point_id' . ($prepaid === '1' ? '_prepaid' : '')])) {
                    $sessionPoint = $this->session->data['boxberry_shipping_issue_point_id' . ($prepaid === '1' ? '_prepaid' : '')];
                } else {
                    $sessionPoint = null;
                }

                if (!$hideDeliveryDay) {
                    $deliveryPeriodText = '&nbsp;<i>(срок доставки - ' . $costData->getDeliveryPeriodPickup() . ' ' . trim($this->getPeriod($costData->getDeliveryPeriodPickup(), 'рабочий день', 'рабочих дня', 'рабочих дней')) . ')</i>';
                } else {
                    $deliveryPeriodText = '';
                }

                $htmlLink = '<a id="boxberry-issue_point-link' . ($prepaid === '1' ? '-prepaid' : '') . '"
                                         href = "#"
                                         data-boxberry-open="true"
                                         data-type="boxberryDeliverySelf' . ($prepaid === '1' ? 'Prepaid' : '') . '"
                                         data-boxberry-token="' . $this->config->get('shipping_boxberry_widget_key') . '"
                                         data-boxberry-city="' . trim($address['city']) . ' ' . $address['zone'] . '"
                                         data-api-url="' . $this->config->get('shipping_boxberry_api_url') . '"
                                         data-sucrh="' . $this->config->get('shipping_boxberry_pickup' . ($prepaid === '1' ? '_prepaid' : '') . '_sucrh') . '"
                                         data-boxberry-weight="' . $dimensions['weight'] . '"
                                         data-boxberry-width="' . $dimensions['width'] . '"
                                         data-boxberry-height="' . $dimensions['height'] . '"
                                         data-boxberry-length="' . $dimensions['depth'] . '"
                                         data-ordersum="' . $this->currency->convert($this->cart->getTotal(), $this->config->get('config_currency'), 'RUB') . '"
                                         data-class="boxberryDeliverySelf' . ($prepaid === '1' ? 'Prepaid' : '') . '"
                                         data-order-id="">' . ($sessionPoint ? 'Выбрать другой пункт выдачи' : 'Выбрать пункт выдачи на карте') . '</a>';
                if ($sessionPoint && ($point = $this->getIssuePointById($sessionPoint, $prepaid))) {
                    $htmlBlock = '<div id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-block" style="margin: 9px;">
                                              <b><span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-name">' . $point['CityName'] . '</span></b>
                                              <br><span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-addr-short">
                                              <a href="https://boxberry.ru/find_an_office/' . $sessionPoint . '" target="_blank">' . $point['AddressReduce'] . '</a></span>
                                              <br><span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-phone">Телефон: ' . $point['Phone'] . ', </span>
                                              <span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-work">часы работы: ' . $point['WorkShedule'] . '</span>
                                              </div>';
                } else {
                    $htmlBlock = '<div id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-block" style="display: none; margin: 9px;">
                                              <b><span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-name"></span></b>
                                              <br><span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-addr-short">
                                              <a href="#" target="_blank"></a></span>
                                              <br><span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-phone"></span>
                                              <span id="boxberry-issue_point' . ($prepaid === '1' ? '-prepaid' : '') . '-work"></span>
                                              </div>';
                }

                return [
                    'code' => 'boxberry.' . $deliveryType,
                    'name' => $this->config->get('shipping_boxberry_' . $deliveryType . '_name') ?: $this->language->get('text_' . $deliveryType . '_description'),
                    'cost' => $this->currency->convert($costData->getTotalPricePickup(), 'RUB', $this->config->get('config_currency')),
                    //'tax_class_id' => 0,
                    'text' => $this->currency->format($this->tax->calculate($costData->getTotalPricePickup(), 0, $this->config->get('config_tax')), $this->config->get('config_currency')) . $deliveryPeriodText . '<br>' . $htmlBlock . $htmlLink,
                ];

            } catch (Exception $e) {
                $this->session->data['boxberry_shipping_fail_cost_issue_point' . ($prepaid === '1' ? '_prepaid' : '')] = 'Не удалось вычислить стоимость доставки';
            }
        } elseif (str_contains($deliveryType, 'courier_delivery')) {

            if (!$costData->getPriceBaseCourier()) {
                return [];
            }

            try {
                unset($this->session->data['boxberry_shipping_fail_cost_' . $deliveryType]);

                if (!$hideDeliveryDay) {
                    $courierDeliveryPeriodText = '&nbsp;<i>(срок доставки - ' . $costData->getDeliveryPeriodCourier() . ' ' . trim($this->getPeriod($costData->getDeliveryPeriodCourier(), 'рабочий день', 'рабочих дня', 'рабочих дней')) . ')</i>';
                } else {
                    $courierDeliveryPeriodText = '';
                }

                return [
                    'code' => 'boxberry.' . $deliveryType,
                    'name' => $this->config->get('shipping_boxberry_' . $deliveryType . '_name') ?: $this->language->get('text_' . $deliveryType . '_description'),
                    'cost' => $this->currency->convert($costData->getTotalPriceCourier(), 'RUB', $this->config->get('config_currency')),
                    'tax_class_id' => 0,
                    'text' => $this->currency->format($this->tax->calculate($costData->getTotalPriceCourier(), 0, $this->config->get('config_tax')), $this->config->get('config_currency')) . $courierDeliveryPeriodText
                ];

            } catch (Exception $e) {
                $this->session->data['boxberry_shipping_fail_cost_' . $deliveryType] = 'Не удалось вычислить стоимость доставки';
            }
        }

        return [];
    }

    private function getZipCheck($zip): string
    {
        try {
            $client = $this->getClient();
            $zipCheck = $client->getZipCheck();
            $zipCheck->setZip($zip);
            $zipCheckResponse = $client->execute($zipCheck);

            if ($zipCheckResponse->getExpressDelivery() === 1) {
                return $zip;
            }
        } catch (Exception $e) {
        }

        return '';
    }
    public function getWidgetSettings(): object|bool
    {
        try {
            $client = $this->getClient();
            $widgetSettingsRequest = $client->getWidgetSettings();

            return $client->execute($widgetSettingsRequest);
        } catch (Exception $e) {
            return false;
        }

    }

    private function isCodAvailableForCountry($isoCode): bool
    {
        if ($isoCode === 'RU' || $isoCode === 'KZ') {
            return true;
        }

        return false;
    }

    public function getBoxberryCity($address)
    {
        $this->load->model('extension/boxberry/boxberry/city');
        $this->load->model('extension/boxberry/boxberry/expired');

        $expired = $this->model_extension_boxberry_boxberry_expired->getExpired(DB_PREFIX . 'boxberry_cities');

        if (!$expired || (strtotime($expired) <= time())) {
            $client = $this->getClient();
            $listCities = $client::getListCitiesFull();
            try {
                $listCitiesResponse = $client->execute($listCities);
            } catch (Exception $e) {
                $listCitiesResponse = [];
            }
            foreach ($listCitiesResponse as $city) {
                $this->model_extension_boxberry_boxberry_city->addCity([
                    'code'   => $city->getCode(),
                    'name'   => $city->getName(),
                    'region' => $city->getRegion(),
                    'data'   => $city->getData()
                ]);
            }
            $this->model_extension_boxberry_boxberry_expired->addExpired(['table' => DB_PREFIX . 'boxberry_cities']);
        }

        return $this->model_extension_boxberry_boxberry_city->getCityByName($address['city'], $address['zone']);
    }

    public function getClient(): Client
    {
        $client = new Client();
        $client->setApiToken($this->config->get('shipping_boxberry_api_token'));
        $client->setApiUrl($this->config->get('shipping_boxberry_api_url'));

        return $client;
    }

    public function getDeliveryCalculationResult($deliveryType, $cityCode, $prepaid, $dimensions, $zip = ''): object|bool|array
    {
        try {
            $client = $this->getClient();
            $orderSum = $this->cart->getTotal();
            $useShopSettings = $this->config->get('shipping_boxberry_' . $deliveryType . '_sucrh');
            $deliveryTypeId = strpos($deliveryType, 'pickup') !== false ? 1 : 2;
            $deliveryCalculation = $client->getDeliveryCalculation();
            $deliveryCalculation->setDeliveryType($deliveryTypeId);
            $deliveryCalculation->setOrdersum($orderSum);
            $deliveryCalculation->setPaysum($prepaid === '1' ? 0 : $orderSum);
            $deliveryCalculation->setRecipientCityId($cityCode);
            $deliveryCalculation->setZip($zip);
            $deliveryCalculation->setWeight($dimensions['weight']);
            $deliveryCalculation->setHeight($dimensions['height']);
            $deliveryCalculation->setWidth($dimensions['width']);
            $deliveryCalculation->setDepth($dimensions['depth']);
            $deliveryCalculation->setBoxSizes();
            $deliveryCalculation->setUseShopSettings($useShopSettings);
            $deliveryCalculation->setCmsName('opencart');
            $deliveryCalculation->setUrl($_SERVER['HTTP_HOST']);
            $deliveryCalculation->setVersion('1.6.10');
            return $client->execute($deliveryCalculation);
        } catch (Exception $e) {
            return [];
        }

    }

    public function getFullDimensions(): array
    {
        $cartItems              = $this->cart->getProducts();
        $minWeight              = $this->config->get('shipping_boxberry_weight_min');
        $defaultWeight          = $this->config->get('shipping_boxberry_weight');
        $defaultDepth           = $this->config->get('shipping_boxberry_depth');
        $defaultHeight          = $this->config->get('shipping_boxberry_height');
        $defaultWidth           = $this->config->get('shipping_boxberry_width');
        $applyDefaultDimensions = $this->config->get('shipping_boxberry_package_size');

        $fullPackage = [];
        $fullPackage['weight'] = 0;
        $fullPackage['depth']  = 0;
        $fullPackage['height'] = 0;
        $fullPackage['width']  = 0;

        if ($applyDefaultDimensions === '1') {
            $fullPackage['weight'] = ceil($defaultWeight);
            $fullPackage['depth']  = ceil($defaultDepth);
            $fullPackage['height'] = ceil($defaultHeight);
            $fullPackage['width']  = ceil($defaultWidth);
        } elseif ($applyDefaultDimensions === '0') {
            $itemsVolume = 0;

            foreach ($cartItems as $item) {
                if ($item['weight_class_id'] === '1') {
                    $item['weight'] = $this->weight->convert(
                        $item['weight'],
                        $this->config->get('config_weight_class_id'),
                        $this->config->get('shipping_boxberry_weight_class_id')
                    );
                }
                $fullPackage['weight'] += (($item['weight'] < (float)$minWeight) ? ($item['quantity'] * ceil($defaultWeight)) : ceil($item['weight']));

                if (((float)$item['width'] + (float)$item['height'] + (float)$item['length']) == 0) {
                    $itemVolume = (int)$item["quantity"] * ((float)$defaultWidth * (float)$defaultHeight * (float)$defaultDepth);
                } else {
                    $itemVolume = (int)$item["quantity"] * ((float)$item['width'] * (float)$item['height'] * (float)$item['length']);
                }

                $itemsVolume += $itemVolume;
            }

            if ($itemsVolume !== 0) {
                $sideDimension = $itemsVolume ** (1 / 3);
                $fullPackage["width"]  += ceil($sideDimension);
                $fullPackage["height"] += ceil($sideDimension);
                $fullPackage["depth"]  += ceil($sideDimension);
            }
        }
        return $fullPackage;
    }

    public function getIssuePointById($issuePointId, $prepaid)
    {
        $this->load->model('extension/boxberry/boxberry/point');
        $point = $this->model_extension_boxberry_boxberry_point->getPoint($issuePointId, $prepaid);

        if (!$point || (strtotime($point['expired']) <= time())) {
            $client = $this->getClient();

            $description = $client::getPointsDescription();
            $description->setCode($issuePointId);
            $description->setPhoto(0);

            try {
                $newPoint = $client->execute($description);
                $newPoint = [
                    'code'      => $issuePointId,
                    'city_code' => $newPoint->getCityCode(),
                    'data'      => $newPoint->getData(),
                    'prepaid'   => $prepaid
                ];
                $this->model_extension_boxberry_boxberry_point->addPoint($newPoint);

                return $newPoint['data'];
            } catch (Exception $e) {

            }
        }

        return json_decode($point['data'], 1);
    }

    public function getPeriod($count, $form1, $form2, $form3)
    {
        $count = abs($count) % 100;
        $lcount = $count % 10;

        if ($count >= 11 && $count <= 19) {
            return $form3;
        }

        if ($lcount >= 2 && $lcount <= 4) {
            return $form2;
        }

        if ($lcount === 1) {
            return $form1;
        }

        return $form3;
    }

    public function unsetKeys($address): void
    {
        $unsetKeys = [
            'fail_city',
            'fail_zip',
            'fail_cost_courier_delivery',
            'fail_cost_issue_point',
            'fail_cost_courier_delivery_prepaid',
            'fail_cost_issue_point_prepaid',
            'fail_weight',
            'fail_size',
            'issue_point_id',
            'issue_point_id_prepaid',
        ];

        if (
            isset($address['city'], $this->session->data['boxberry_shipping_city_name']) &&
            str_replace(['Ё', 'РП'], ['Е', ''], mb_strtoupper(trim($address['city']))) !==
            str_replace(['Ё', 'РП'], ['Е', ''], mb_strtoupper(trim($this->session->data['boxberry_shipping_city_name'])))
        ) {
            foreach ($unsetKeys as $unsetKey) {
                unset($this->session->data['boxberry_shipping_' . $unsetKey]);
            }
        }
    }
}