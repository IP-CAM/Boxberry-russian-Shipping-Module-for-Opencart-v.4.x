<?php
/**
 *
 *  * This file is part of Boxberry Api.
 *  *
 *  * (c) 2016, T. I. R. Ltd.
 *  * Evgeniy Mosunov, Alexander Borovikov
 *  *
 *  * For the full copyright and license information, please view LICENSE
 *  * file that was distributed with this source code
 *  *
 *  * File: Parsel.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

use Boxberry\Collections\Exceptions\BadValueException;
use Boxberry\Collections\Items;

/**
 * Class Parsel
 * @package Boxberry\Models
 *
 * @var array  $propNameMap
 * @var string $sourcePlatform
 * @var string $imId
 * @var string $label
 * @var string $track
 * @var string $orderId
 * @var string $palletNumber
 * @var string $barCode
 * @var string $price
 * @var string $paymentSum
 * @var string $deliverySum
 * @var string $vid
 * @var array  $weights
 * @var array  $shop
 * @var Items  $items
 * @var Customer $customer
 * @var CourierDelivery $courierDelivery
 * @var CourierDeliveryExport $export
 */
class Parsel extends ParselStory
{
    protected array $propNameMap = array(
        'source_platform' => 'sourcePlatform',
        'updateByTrack'   => 'track',
        'order_id'        => 'orderId',
        'PalletNumber'    => 'palletNumber',
        'barCode'         => 'barCode',
        'price'           => 'price',
        'payment_sum'     => 'paymentSum',
        'delivery_sum'    => 'deliverySum',
        'vid'             => 'vid',
        'kurdost'         => 'courierDelivery',
        'customer'        => 'customer',
        'items'           => 'items',
        'weights'         => 'weights',
        'shop'            => 'shop',
        'export'          => 'export',
    );
    protected string $sourcePlatform = '';
    protected string $imId           = '';
    protected string $label          = '';
    protected string $track          = '';
    protected string $orderId        = '';
    protected string $palletNumber   = '';
    protected string $barCode        = '';
    protected string $price          = '';
    protected string $paymentSum     = '';
    protected string $deliverySum    = '';
    protected string $vid            = '';
    protected array  $weights        = array();
    protected array  $shop           = array();
    protected Items  $items;
    protected Customer $customer;
    protected CourierDelivery $courierDelivery;
    protected CourierDeliveryExport $export;

    /**
     * @return string
     */
    public function getSourcePlatform(): string
    {
        return $this->sourcePlatform;
    }

    /**
     * @param string $sourcePlatform
     */
    public function setSourcePlatform(string $sourcePlatform): void
    {
        $this->sourcePlatform = $sourcePlatform;
    }

    /**
     * @return string
     */
    public function getImId(): string
    {
        return $this->imId;
    }

    /**
     * @param string $imId
     */
    public function setImId(string $imId): void
    {
        $this->imId = $imId;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }
    /**
     * @return string
     */
    public function getTrack(): string
    {
        return $this->track;
    }

    /**
     * @param string $track
     */
    public function setTrack(string $track): void
    {
        $this->track = $track;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return CourierDelivery
     */
    public function getCourierDelivery(): CourierDelivery
    {
        return $this->courierDelivery;
    }

    /**
     * @param CourierDelivery $courierDelivery
     */
    public function setCourierDelivery(CourierDelivery $courierDelivery): void
    {
        $this->courierDelivery = $courierDelivery;
    }

    /**
     * @return array
     */
    public function getWeights(): array
    {
        return $this->weights;
    }

    /**
     * @param array $weights
     */
    public function setWeights(array $weights): void
    {
        $this->weights = $weights;
    }

    /**
     * @return array
     */
    public function getShop(): array
    {
        return $this->shop;
    }

    /**
     * @param array $shop
     */
    public function setShop(array $shop): void
    {
        $this->shop = $shop;
    }

    /**
     * @return string
     */
    public function getVid(): string
    {
        return $this->vid;
    }

    /**
     * @param string $vid
     */
    public function setVid(string $vid): void
    {
        $this->vid = $vid;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getPalletNumber(): string
    {
        return $this->palletNumber;
    }

    /**
     * @param string $palletNumber
     */
    public function setPalletNumber(string $palletNumber): void
    {
        $this->palletNumber = $palletNumber;
    }

    /**
     * @return string
     */
    public function getBarCode(): string
    {
        return $this->barCode;
    }

    /**
     * @param string $barcode
     */
    public function setBarCode(string $barcode): void
    {
        $this->barCode = $barcode;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getPaymentSum(): string
    {
        return $this->paymentSum;
    }

    /**
     * @param string $paymentSum
     */
    public function setPaymentSum(string $paymentSum): void
    {
        $this->paymentSum = $paymentSum;
    }

    /**
     * @return string
     */
    public function getDeliverySum(): string
    {
        return $this->deliverySum;
    }

    /**
     * @param string $deliverySum
     */
    public function setDeliverySum(string $deliverySum): void
    {
        $this->deliverySum = $deliverySum;
    }

    /**
     * @return Items
     */
    public function getItems(): Items
    {
        return $this->items;
    }

    /**
     * @param Items $items
     * @throws BadValueException
     */
    public function setItems(Items $items): void
    {
        $this->items = new Items($items);

        $i = 1;

        foreach($items as $item) {
            if ($item->getWeight() !== null) {
                $this->weights['weight'.($i > 1 ? $i : '')] = $item->getWeight();
            }
            $i++;
        }
    }

    /**
     * @return CourierDeliveryExport
     */
    public function getExport(): CourierDeliveryExport
    {
        return $this->export;
    }

    /**
     * @param CourierDeliveryExport $export
     */
    public function setExport(CourierDeliveryExport $export): void
    {
        $this->export = $export;
    }
}