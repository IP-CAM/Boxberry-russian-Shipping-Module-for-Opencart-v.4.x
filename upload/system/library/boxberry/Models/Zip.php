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
 *  * File: Zip.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class Zip
 * @package Boxberry\Models
 *
 * @var string $zip
 * @var string $city
 * @var string $region
 * @var string $area
 * @var string $zoneExpressDelivery
 */
class Zip extends ShortZip
{
    protected string $zip                 = '';
    protected string $city                = '';
    protected string $region              = '';
    protected string $area                = '';
    protected string $zoneExpressDelivery = '';

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * @return string
     */
    public function getZoneExpressDelivery(): string
    {
        return $this->zoneExpressDelivery;
    }

    /**
     * @param string $zoneExpressDelivery
     */
    public function setZoneExpressDelivery(string $zoneExpressDelivery): void
    {
        $this->zoneExpressDelivery = $zoneExpressDelivery;
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @param string $area
     */
    public function setArea(string $area): void
    {
        $this->area = $area;
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
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}