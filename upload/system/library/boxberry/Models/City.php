<?php
/**
 *
 *  * This file is part of Boxberry Api.
 *  *
 *  * (c) 2016, T. I. R. Ltd.
 *  * я
 *  *
 *  * For the full copyright and license information, please view LICENSE
 *  * file that was distributed with this source code
 *  *
 *  * File: City.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;
use Boxberry\Collections\ListCitiesCollection;

/**
 * Class City
 * @package Boxberry\Models
 *
 * @var string $name
 * @var string $code
 * @var string $region
 * @var string $country_code
 * @var string $uniq_name
 * @var string $pickup_point
 * @var string $courier_delivery
 * @var array  $data
 */
class City extends AbstractModel
{
    protected string $name             = '';
    protected string $code             = '';
    protected string $region           = '';
    protected string $country_code     = '';
    protected string $uniq_name        = '';
    protected string $pickup_point     = '';
    protected string $courier_delivery = '';
    protected array  $data             = array();

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }
    /**
     * @param string $country_code
     */
    public function setCountryCode(string $country_code): void
    {
        $this->country_code = $country_code;
    }

    /**
     * @return string
     */
    public function getUniqName(): string
    {
        return $this->uniq_name;
    }

    /**
     * @param string $uniq_name
     */
    public function setUniqName(string $uniq_name): void
    {
        $this->uniq_name = $uniq_name;
    }

    /**
     * @return string
     */
    public function getPickupPoint(): string
    {
        return $this->pickup_point;
    }

    /**
     * @param string $pickup_point
     */
    public function setPickupPoint(string $pickup_point): void
    {
        $this->pickup_point = $pickup_point;
    }

    /**
     * @return string
     */
    public function getCourierDelivery(): string
    {
        return $this->courier_delivery;
    }

    /**
     * @param string $courier_delivery
     */
    public function setCourierDelivery(string $courier_delivery): void
    {
        $this->courier_delivery = $courier_delivery;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}