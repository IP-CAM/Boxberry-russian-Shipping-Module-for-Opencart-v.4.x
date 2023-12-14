<?php

namespace Opencart\Catalog\Controller\Event;

use Exception;

if (!class_exists('Client')) {
    require_once DIR_EXTENSION . 'boxberry/system/library/boxberry/autoload.php';
}
/**
 * Class Boxberry
 *
 * @package Opencart\Catalog\Controller\Event
 */
class Boxberry extends \Opencart\System\Engine\Controller
{
    const EAEU_COURIER_DEFAULT_INDEX = '151';
    const TRANSPORTER_GUID = 'fd85a8b6-4688-404f-9993-30b9e55d2950';
    private string $error = '';

    public function AddScripts(): void
    {
        $this->document->addScript('catalog/view/javascript/boxberry.js');
        $this->document->addScript($this->config->get('shipping_boxberry_widget_url'));
    }

    public function addOrderHistory(&$route, &$args): void
    {
        $this->load->model('checkout/order');
        $this->load->model('boxberry/delivery');
        $this->load->model('catalog/product');

        $orderInfo = $this->model_checkout_order->getOrder($args[0]);

        if (!in_array($orderInfo['shipping_code'], ['boxberry.pickup', 'boxberry.courier_delivery', 'boxberry.pickup_prepaid', 'boxberry.courier_delivery_prepaid'])) {
            return;
        }

        if ($orderInfo && $args[1]) {
            $orderId = (int)$args[0];
            $boxberryDelivery = $this->model_boxberry_delivery->getDelivery($orderInfo['order_id']);

            $city = $orderInfo['shipping_city'];
            $index = $orderInfo['shipping_postcode'];
            $region = $orderInfo['shipping_zone'];
            $address = $orderInfo['shipping_address_1'];
            $email = $orderInfo['email'];
            $phone = $orderInfo['telephone'];
            $receiver = $orderInfo['lastname'] . ' ' . $orderInfo['firstname'];

            $imId = null;
            $label = null;

            $boxberryToPoint = '';
            if (str_contains($orderInfo['payment_address_1'], '#')) {
                $point = explode(' ', $orderInfo['payment_address_1']);
                $point = $point[1];
            }
            if (str_contains($orderInfo['payment_address_2'], '#')) {
                $point = explode(' ', $orderInfo['payment_address_2']);
                $point = $point[1];
            }
            if (str_contains($orderInfo['shipping_address_1'], '#')) {
                $point = explode(' ', $orderInfo['shipping_address_1']);
                $point = $point[1];
            }
            if (str_contains($orderInfo['shipping_address_2'], '#')) {
                $point = explode(' ', $orderInfo['shipping_address_2']);
                $point = $point[1];
            }

            if (!empty($point)) {
                $boxberryToPoint = $point;
            }

            if ($boxberryDelivery !== null) {
                $imId = $boxberryDelivery['im_id'];
                $label = $boxberryDelivery['label'];
            }

            if ((($orderInfo['shipping_code'] === 'boxberry.pickup') && ($this->config->get('shipping_boxberry_pickup_parselcreate_auto') === '1'))
                || (($orderInfo['shipping_code'] === 'boxberry.pickup_prepaid') && ($this->config->get('shipping_boxberry_pickup_prepaid_parselcreate_auto') === '1'))
                || (($orderInfo['shipping_code'] === 'boxberry.courier_delivery') && ($this->config->get('shipping_boxberry_courier_delivery_parselcreate_auto') === '1'))
                || (($orderInfo['shipping_code'] === 'boxberry.courier_delivery_prepaid') && ($this->config->get('shipping_boxberry_courier_delivery_prepaid_parselcreate_auto') === '1'))
                || ($args[1] == $this->config->get('shipping_boxberry_order_status'))) {
                $client = new \Boxberry\Client\Client();
                $client->setKey($this->config->get('shipping_boxberry_api_token'));
                $client->setApiUrl($this->config->get('shipping_boxberry_api_url'));

                $parselCreate = $client->getParselCreate();
                $parsel = new  \Boxberry\Models\Parsel();

                $parsel->setSourcePlatform('opencart');
                if ($boxberryDelivery) {
                    $parsel->setTrack($boxberryDelivery['im_id']);
                }
                $parsel->setOrderId($orderInfo['order_id']);

                $parsel->setPrice($orderInfo['total']);
                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . $orderId . "' ORDER BY sort_order ASC");

                $orderTotals = $query->rows;
                foreach ($orderTotals as $total) {
                    $totals[$total['code']] = $total['value'];
                }

                $deliveryCost = isset($totals['shipping']) ?
                    $this->currency->convert($totals['shipping'], $orderInfo['currency_code'], 'RUB') : 0;
                $parsel->setDeliverySum($deliveryCost);

                if ($orderInfo['shipping_code'] === 'boxberry.courier_delivery_prepaid' || $orderInfo['shipping_code'] === 'boxberry.pickup_prepaid') {
                    $parsel->setPaymentSum(0);
                } else {
                    $parsel->setPaymentSum($this->currency->convert($orderInfo['total'], $orderInfo['currency_code'], 'RUB'));
                }

                $customer = new \Boxberry\Models\Customer();
                $customer->setFio($receiver);
                $customer->setEmail($email);
                $customer->setPhone($phone);
                $parsel->setCustomer($customer);

                $items = new \Boxberry\Collections\Items();
                $orderProductsQuery = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . $orderId . "'");
                $orderItems = $orderProductsQuery->rows;

                foreach ($orderItems as $key => $orderItem) {
                    $item = new \Boxberry\Models\Item();
                    $item->setId($orderItem['product_id']);
                    $item->setName($orderItem['name']);
                    $item->setPrice($this->currency->convert($orderItem['price'], $this->config->get('config_currency'), 'RUB'));
                    $item->setQuantity(ceil($orderItem['quantity']));
                    $items[] = $item;
                }
                $parsel->setItems($items);

                if ($this->cart->getWeight() !== 0) {
                    $parsel->setWeights(['weight' => $this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->config->get('shipping_boxberry_weight_class_id'))]);
                } else {
                    $getWeightQuery = $this->db->query("SELECT SUM(weight * op.quantity) as weight FROM " . DB_PREFIX . "order_product op JOIN " . DB_PREFIX . "product p USING(product_id) WHERE order_id = '" . (int)$orderInfo['order_id'] . "'")->row;
                    $parsel->setWeights(['weight' => $this->weight->convert((int)$getWeightQuery['weight'], $this->config->get('config_weight_class_id'), $this->config->get('shipping_boxberry_weight_class_id'))]);

                    if ($parsel->getWeights()['weight'] == 0) {
                        $parsel->setWeights(['weight' => $this->config->get('shipping_boxberry_weight')]);
                    }
                }

                $shop = array(
                    'name' => '',
                    'name1' => $this->config->get('shipping_boxberry_from_point')
                );

                if ($orderInfo['shipping_code'] === 'boxberry.courier_delivery_prepaid' || $orderInfo['shipping_code'] === 'boxberry.courier_delivery') {
                    $parsel->setVid(2);

                    if ((isset($orderInfo['shipping_iso_code_2']) && $orderInfo['shipping_iso_code_2'] !== 'RU') ||
                        (isset($orderInfo['payment_iso_code_2']) && $orderInfo['payment_iso_code_2'] !== 'RU')) {
                        $this->makeExportArray($orderInfo, $parsel, $client);
                    }

                    if ($this->error){
                        $this->model_boxberry_delivery->addDelivery($this->getBbDeliveryData($orderInfo));
                        return;
                    }

                    $courierDost = new \Boxberry\Models\CourierDelivery();

                    if ($index === '') {
                        $courierDost->setIndex('');
                    } else {
                        $courierDost->setIndex($index);
                    }

                    $courierDost->setCity($city);
                    $courierDost->setAddressp($address);
                    $parsel->setCourierDelivery($courierDost);
                } else {
                    $parsel->setVid(1);
                    $shop['name'] = $boxberryToPoint;
                }

                $parsel->setShop($shop);
                $parselCreate->setParsel($parsel);
                $actLabel = '';
                $trackingLink = '';

                try {
                    $answer = $client->execute($parselCreate);
                    if (!empty($answer->getTrack())) {
                        $imIdsList = new \Boxberry\Collections\ImgIdsCollection(array($imId = $answer->getTrack()));
                        $label = $answer->getLabel();
                        if ((($orderInfo['shipping_code'] === 'boxberry.pickup') && ($this->config->get('shipping_boxberry_pickup_parselsend_auto') === '1'))
                            || (($orderInfo['shipping_code'] === 'boxberry.pickup_prepaid') && ($this->config->get('shipping_boxberry_pickup_prepaid_parselsend_auto') === '1'))
                            || (($orderInfo['shipping_code'] === 'boxberry.courier_delivery') && ($this->config->get('shipping_boxberry_courier_delivery_parselsend_auto') === '1'))
                            || (($orderInfo['shipping_code'] === 'boxberry.courier_delivery_prepaid') && ($this->config->get('shipping_boxberry_courier_delivery_prepaid_parselsend_auto') === '1'))) {
                            $parselSend = $client->getParselSend();
                            $parselSend->setImgIdsList($imIdsList);
                            $parselSend = $client->execute($parselSend);
                            $actLabel = $parselSend->getActLabel();
                            $trackingLink = 'https://boxberry.ru/tracking-page?id=' . $imId;
                        }
                    }
                } catch (Exception $e) {
                    $this->error = $e->getMessage();
                }

                $this->model_boxberry_delivery->addDelivery($this->getBbDeliveryData($orderInfo, $imId, $label, $boxberryToPoint, $address, $city, $index, $trackingLink, $actLabel));

            }
        }
    }

    private function makeExportArray($orderInfo, $parcel, $client): void
    {
        try {
            $dadataSuggestions = $client->getDadataSuggestions();
            $dadataSuggestions->setQuery($orderInfo['shipping_city'] . ' ' . $orderInfo['shipping_address_1']);
            $dadataSuggestions->setLocations();
            $dadataSuggestions->fixCityName();
            $dadataRequestResult = $client->execute($dadataSuggestions);
        } catch (Exception $e) {
            $this->error = 'Не удалось определить город, попробуйте отредактировать адрес и выгрузить заказ повторно, либо создать заказ вручную в ЛК.';
            return;
        }

        $this->load->model('boxberry/city');

        if (!$cityInfo = $this->model_boxberry_city->getCityByName($orderInfo['shipping_city'], $orderInfo['shipping_zone'])) {
            $this->error = 'Не удалось найти город в базе.';
            return;
        }

        try {
            $export = new \Boxberry\Models\CourierDeliveryExport();
            $export->setIndex(self::EAEU_COURIER_DEFAULT_INDEX);
            $export->setCountryCode($cityInfo['data']['CountryCode']);
            $export->setCityCode($cityInfo['code']);
            $export->setArea($dadataRequestResult->getArea());
            $export->setStreet($dadataRequestResult->getStreet());
            $export->setHouse($dadataRequestResult->getHouse());
            $export->setFlat($dadataRequestResult->getFlat());
            $export->setTransporterGuid(self::TRANSPORTER_GUID);
            $parcel->setExport($export);
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return;
        }

    }

    private function getBbDeliveryData($orderInfo, $imId = '', $label = '', $boxberryToPoint = '', $address = '', $city = '', $index = '', $trackingLink = '', $actLabel = ''): array
    {
        return [
            'order_id' => $orderInfo['order_id'],
            'im_id' => (!empty($actLabel) && !empty($trackingLink)) ? $imId . ' ' . $trackingLink : $imId,
            'label' => (!empty($actLabel) && !empty($trackingLink)) ? $label . ' ' . $actLabel : $label,
            'boxberry_to_point' => (strpos($orderInfo['shipping_code'], 'courier_delivery') ? 'Курьер' : $boxberryToPoint),
            'address' => (strpos($orderInfo['shipping_code'], 'courier_delivery') ? $index . ', ' . $city . ', ' . $address : $address),
            'error' => (!empty($this->error) && mb_strpos($this->error, 'обновление') !== false) ? '' : $this->error
        ];
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }
}