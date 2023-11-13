<?php

namespace Boxberry\Models;

use Exception;

/**
 * Class DeliveryCalculation
 * @package Boxberry\Models
 *
 * @var int $totalPricePickup
 * @var int $totalPriceCourier
 * @var int $priceBasePickup
 * @var int $priceBaseCourier
 * @var int $deliveryPeriodPickup
 * @var int $deliveryPeriodCourier
 */
class DeliveryCalculation extends AbstractModel
{
    const PICKUP_DELIVERY_TYPE_ID  = 1;
    const COURIER_DELIVERY_TYPE_ID = 2;

    protected int $totalPricePickup      = 0;
    protected int $totalPriceCourier     = 0;
    protected int $priceBasePickup       = 0;
    protected int $priceBaseCourier      = 0;
    protected int $deliveryPeriodPickup  = 0;
    protected int $deliveryPeriodCourier = 0;

    /**
     * DeliveryCalculation constructor.
     * @param array $data
     * @throws Exception
     */
    public function __construct($data)
    {
        if (empty($data) || isset($data['err']) || (isset($data['error']) && $data['error'] === true) ||
            (!isset($data['result']['DeliveryCosts']) && !is_array($data['result']['DeliveryCosts']))) {
            throw new Exception('Доставка до выбранного места невозможна');
        }

        foreach ($data['result']['DeliveryCosts'] as $deliveryCost) {
            if ($deliveryCost['DeliveryTypeId'] === self::PICKUP_DELIVERY_TYPE_ID) {
                $this->totalPricePickup = $deliveryCost['TotalPrice'];
                $this->priceBasePickup = $deliveryCost['PriceBase'];
                $this->deliveryPeriodPickup = $deliveryCost['DeliveryPeriod'];
            }

            if ($deliveryCost['DeliveryTypeId'] === self::COURIER_DELIVERY_TYPE_ID) {
                $this->totalPriceCourier = $deliveryCost['TotalPrice'];
                $this->priceBaseCourier = $deliveryCost['PriceBase'];
                $this->deliveryPeriodCourier = $deliveryCost['DeliveryPeriod'];
            }
        }

        parent::__construct();
    }

    /**
     * @return int
     */
    public function getTotalPricePickup(): int
    {
        return $this->totalPricePickup;
    }

    /**
     * @param int $totalPricePickup
     */
    public function setTotalPricePickup(int $totalPricePickup): void
    {
        $this->totalPricePickup = $totalPricePickup;
    }

    /**
     * @return int
     */
    public function getTotalPriceCourier(): int
    {
        return $this->totalPriceCourier;
    }

    /**
     * @param int $totalPriceCourier
     */
    public function setTotalPriceCourier(int $totalPriceCourier): void
    {
        $this->totalPriceCourier = $totalPriceCourier;
    }

    /**
     * @return int
     */
    public function getPriceBasePickup(): int
    {
        return $this->priceBasePickup;
    }

    /**
     * @param int $priceBasePickup
     */
    public function setPriceBasePickup(int $priceBasePickup): void
    {
        $this->priceBasePickup = $priceBasePickup;
    }

    /**
     * @return int
     */
    public function getPriceBaseCourier(): int
    {
        return $this->priceBaseCourier;
    }

    /**
     * @param int $priceBaseCourier
     */
    public function setPriceBaseCourier(int $priceBaseCourier): void
    {
        $this->priceBaseCourier = $priceBaseCourier;
    }

    /**
     * @return int
     */
    public function getDeliveryPeriodPickup(): int
    {
        return $this->deliveryPeriodPickup;
    }

    /**
     * @param int $deliveryPeriodPickup
     */
    public function setDeliveryPeriodPickup(int $deliveryPeriodPickup): void
    {
        $this->deliveryPeriodPickup = $deliveryPeriodPickup;
    }

    /**
     * @return int
     */
    public function getDeliveryPeriodCourier(): int
    {
        return $this->deliveryPeriodCourier;
    }

    /**
     * @param int $deliveryPeriodCourier
     */
    public function setDeliveryPeriodCourier(int $deliveryPeriodCourier): void
    {
        $this->deliveryPeriodCourier = $deliveryPeriodCourier;
    }

}