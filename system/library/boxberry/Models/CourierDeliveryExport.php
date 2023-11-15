<?php

namespace Boxberry\Models;

/**
 * Class CourierDeliveryExport
 * @package Boxberry\Models
 *
 * @var string $index
 * @var string $countryCode
 * @var string $cityCode
 * @var string $area
 * @var string $street
 * @var string $flat
 * @var string $transporterGuid
 */
class CourierDeliveryExport extends AbstractModel
{
    protected array $propNameMap = array(
        'index'           => 'index',
        'countryCode'     => 'countryCode',
        'cityCode'        => 'cityCode',
        'area'            => 'area',
        'street'          => 'street',
        'house'           => 'house',
        'flat '           => 'flat',
        'transporterGuid' => 'transporterGuid',
    );

    protected string $index           = '';
    protected string $countryCode     = '';
    protected string $cityCode        = '';
    protected string $area            = '';
    protected string $street          = '';
    protected string $house           = '';
    protected string $flat            = '';
    protected string $transporterGuid = '';

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getCityCode(): string
    {
        return $this->cityCode;
    }

    /**
     * @param string $cityCode
     */
    public function setCityCode(string $cityCode): void
    {
        $this->cityCode = $cityCode;
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
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getHouse(): string
    {
        return $this->house;
    }

    /**
     * @param string $house
     */
    public function setHouse(string $house): void
    {
        $this->house = $house;
    }

    /**
     * @return string
     */
    public function getFlat(): string
    {
        return $this->flat;
    }

    /**
     * @param string $flat
     */
    public function setFlat(string $flat): void
    {
        $this->flat = $flat;
    }

    /**
     * @return string
     */
    public function getTransporterGuid(): string
    {
        return $this->transporterGuid;
    }

    /**
     * @param string $transporterGuid
     */
    public function setTransporterGuid(string $transporterGuid): void
    {
        $this->transporterGuid = $transporterGuid;
    }


}