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
 *  * File: DeliveryCosts.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

use Boxberry\Client\Exceptions\BadResponseException;
use Exception;

/**
 * Class DeliveryCosts
 * @package Boxberry\Models
 *
 * @var float  $price
 * @var int    $price_base
 * @var float  $price_service
 * @var string $delivery_period
 *
 */
class DeliveryCosts extends AbstractModel
{
    protected float  $price           = 0;
    protected int    $price_base      = 0;
    protected float  $price_service   = 0;
    protected string $delivery_period = "0";

    /**
     * DeliveryCosts constructor.
     * @param array $data
     * @throws BadResponseException|Exception
     */
    public function __construct(array $data)
    {
        if ((float)$data['price_base'] <= 0) {
            throw new Exception('Доставка до выбранного места невозможна');
        }
        $this->price = $data['price'];
        $this->price_base = $data['price_base'];
        $this->price_service = $data['price_service'];
        $this->delivery_period = $data['delivery_period'];
        parent::__construct();
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPriceService(): float
    {
        return $this->price_service;
    }

    /**
     * @param float $price_service
     */
    public function setPriceService(float $price_service): void
    {
        $this->price_service = $price_service;
    }

    /**
     * @return int
     */
    public function getPriceBase(): int
    {
        return $this->price_base;
    }

    /**
     * @param int $price_base
     * @throws BadResponseException|Exception
     */
    public function setPriceBase(int $price_base): void
    {
        if ((float)$price_base <=0 ) {
            throw new Exception('Доставка до выбранного места невозможна');
        }
        $this->price_base = $price_base;
    }

    /**
     * @return string
     */
    public function getDeliveryPeriod(): string
    {
        return $this->delivery_period;
    }

    /**
     * @param string $delivery_period
     */
    public function setDeliveryPeriod(string $delivery_period): void
    {
        $this->delivery_period = $delivery_period;
    }
}