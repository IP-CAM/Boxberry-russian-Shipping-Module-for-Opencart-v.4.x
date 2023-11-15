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
 *  * File: Point.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class Point
 * @package Boxberry\Models
 *
 * @var string $code
 * @var string $name
 * @var string $address
 * @var string $phone
 * @var string $tripDescription
 * @var string $deliveryPeriod
 * @var string $cityCode
 * @var string $cityName
 * @var string $tarrifZone
 * @var string $settlement
 * @var string $area
 * @var string $country
 * @var string $gps
 * @var string $onlyPrepaidOrders
 * @var string $prepaidOrdersOnly
 * @var string $addressReduce
 * @var string $acquiring
 * @var string $digitalSignature
 * @var string $typeOfOffice
 * @var string $nalKD
 * @var string $metro
 * @var string $workSchedule
 * @var string $workMoBegin
 * @var string $workMoEnd
 * @var string $workTuBegin
 * @var string $workTuEnd
 * @var string $workWeBegin
 * @var string $workWeEnd
 * @var string $workThBegin
 * @var string $workThEnd
 * @var string $workFrBegin
 * @var string $workFrEnd
 * @var string $workSaBegin
 * @var string $workSaEnd
 * @var string $workSuBegin
 * @var string $workSuEnd
 * @var string $lunchMoBegin
 * @var string $lunchMoEnd
 * @var string $lunchTuBegin
 * @var string $lunchTuEnd
 * @var string $lunchWeBegin
 * @var string $lunchWeEnd
 * @var string $lunchThBegin
 * @var string $lunchThEnd
 * @var string $lunchFrBegin
 * @var string $lunchFrEnd
 * @var string $lunchSaBegin
 * @var string $lunchSaEnd
 * @var string $lunchSuBegin
 * @var string $lunchSuEnd
 * @var array  $photos
 * @var string $terminalCode
 * @var string $terminalName
 * @var string $terminalOrganization
 * @var string $terminalCityCode
 * @var string $terminalCityName
 * @var string $terminalAddress
 * @var string $terminalPhone
 * @var bool   $reception
 * @var array  $data
 */
class Point extends ShortPoint
{
    protected string $code                 = '';
    protected string $name                 = '';
    protected string $address              = '';
    protected string $phone                = '';
    protected string $tripDescription      = '';
    protected string $deliveryPeriod       = '';
    protected string $cityCode             = '';
    protected string $cityName             = '';
    protected string $tarrifZone           = '';
    protected string $settlement           = '';
    protected string $area                 = '';
    protected string $country              = '';
    protected string $gps                  = '';
    protected string $onlyPrepaidOrders    = '';
    protected string $prepaidOrdersOnly    = '';
    protected string $addressReduce        = '';
    protected string $acquiring            = '';
    protected string $digitalSignature     = '';
    protected string $typeOfOffice         = '';
    protected string $nalKD                = '';
    protected string $metro                = '';
    protected string $workSchedule         = '';
    protected string $workMoBegin          = '';
    protected string $workMoEnd            = '';
    protected string $workTuBegin          = '';
    protected string $workTuEnd            = '';
    protected string $workWeBegin          = '';
    protected string $workWeEnd            = '';
    protected string $workThBegin          = '';
    protected string $workThEnd            = '';
    protected string $workFrBegin          = '';
    protected string $workFrEnd            = '';
    protected string $workSaBegin          = '';
    protected string $workSaEnd            = '';
    protected string $workSuBegin          = '';
    protected string $workSuEnd            = '';
    protected string $lunchMoBegin         = '';
    protected string $lunchMoEnd           = '';
    protected string $lunchTuBegin         = '';
    protected string $lunchTuEnd           = '';
    protected string $lunchWeBegin         = '';
    protected string $lunchWeEnd           = '';
    protected string $lunchThBegin         = '';
    protected string $lunchThEnd           = '';
    protected string $lunchFrBegin         = '';
    protected string $lunchFrEnd           = '';
    protected string $lunchSaBegin         = '';
    protected string $lunchSaEnd           = '';
    protected string $lunchSuBegin         = '';
    protected string $lunchSuEnd           = '';
    protected array  $photos               = array();
    protected string $terminalCode         = '';
    protected string $terminalName         = '';
    protected string $terminalOrganization = '';
    protected string $terminalCityCode     = '';
    protected string $terminalCityName     = '';
    protected string $terminalAddress      = '';
    protected string $terminalPhone        = '';
    protected bool   $reception            = false;
    protected array  $data                 = array();

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
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getTripDescription(): string
    {
        return $this->tripDescription;
    }

    /**
     * @param string $tripDescription
     */
    public function setTripDescription(string $tripDescription): void
    {
        $this->tripDescription = $tripDescription;
    }

    /**
     * @return string
     */
    public function getDeliveryPeriod(): string
    {
        return $this->deliveryPeriod;
    }

    /**
     * @param string $deliveryPeriod
     */
    public function setDeliveryPeriod(string $deliveryPeriod): void
    {
        $this->deliveryPeriod = $deliveryPeriod;
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
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }

    /**
     * @return string
     */
    public function getTarrifZone(): string
    {
        return $this->tarrifZone;
    }

    /**
     * @param string $tarrifZone
     */
    public function setTarrifZone(string $tarrifZone): void
    {
        $this->tarrifZone = $tarrifZone;
    }

    /**
     * @return string
     */
    public function getSettlement(): string
    {
        return $this->settlement;
    }

    /**
     * @param string $settlement
     */
    public function setSettlement(string $settlement): void
    {
        $this->settlement = $settlement;
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
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getGps(): string
    {
        return $this->gps;
    }

    /**
     * @param string $gps
     */
    public function setGps(string $gps): void
    {
        $this->gps = $gps;
    }

    /**
     * @return string
     */
    public function getOnlyPrepaidOrders(): string
    {
        return $this->onlyPrepaidOrders;
    }

    /**
     * @param string $onlyPrepaidOrders
     */
    public function setOnlyPrepaidOrders(string $onlyPrepaidOrders): void
    {
        $this->onlyPrepaidOrders = $onlyPrepaidOrders;
    }

    /**
     * @return string
     */
    public function getPrepaidOrdersOnly(): string
    {
        return $this->prepaidOrdersOnly;
    }

    /**
     * @param string $prepaidOrdersOnly
     */
    public function setPrepaidOrdersOnly(string $prepaidOrdersOnly): void
    {
        $this->prepaidOrdersOnly = $prepaidOrdersOnly;
    }

    /**
     * @return string
     */
    public function getAddressReduce(): string
    {
        return $this->addressReduce;
    }

    /**
     * @param string $addressReduce
     */
    public function setAddressReduce(string $addressReduce): void
    {
        $this->addressReduce = $addressReduce;
    }

    /**
     * @return string
     */
    public function getAcquiring(): string
    {
        return $this->acquiring;
    }

    /**
     * @param string $acquiring
     */
    public function setAcquiring(string $acquiring): void
    {
        $this->acquiring = $acquiring;
    }

    /**
     * @return string
     */
    public function getDigitalSignature(): string
    {
        return $this->digitalSignature;
    }

    /**
     * @param string $digitalSignature
     */
    public function setDigitalSignature(string $digitalSignature): void
    {
        $this->digitalSignature = $digitalSignature;
    }

    /**
     * @return string
     */
    public function getTypeOfOffice(): string
    {
        return $this->typeOfOffice;
    }

    /**
     * @param string $typeOfOffice
     */
    public function setTypeOfOffice(string $typeOfOffice): void
    {
        $this->typeOfOffice = $typeOfOffice;
    }

    /**
     * @return string
     */
    public function getNalKD(): string
    {
        return $this->nalKD;
    }

    /**
     * @param string $nalKD
     */
    public function setNalKD(string $nalKD): void
    {
        $this->nalKD = $nalKD;
    }

    /**
     * @return string
     */
    public function getMetro(): string
    {
        return $this->metro;
    }

    /**
     * @param string $metro
     */
    public function setMetro(string $metro): void
    {
        $this->metro = $metro;
    }

    /**
     * @return string
     */
    public function getWorkSchedule(): string
    {
        return $this->workSchedule;
    }

    /**
     * @param string $workSchedule
     */
    public function setWorkSchedule(string $workSchedule): void
    {
        $this->workSchedule = $workSchedule;
    }

    /**
     * @return string
     */
    public function getWorkMoBegin(): string
    {
        return $this->workMoBegin;
    }

    /**
     * @param string $workMoBegin
     */
    public function setWorkMoBegin(string $workMoBegin): void
    {
        $this->workMoBegin = $workMoBegin;
    }

    /**
     * @return string
     */
    public function getWorkMoEnd(): string
    {
        return $this->workMoEnd;
    }

    /**
     * @param string $workMoEnd
     */
    public function setWorkMoEnd(string $workMoEnd): void
    {
        $this->workMoEnd = $workMoEnd;
    }

    /**
     * @return string
     */
    public function getWorkTuBegin(): string
    {
        return $this->workTuBegin;
    }

    /**
     * @param string $workTuBegin
     */
    public function setWorkTuBegin(string $workTuBegin): void
    {
        $this->workTuBegin = $workTuBegin;
    }

    /**
     * @return string
     */
    public function getWorkTuEnd(): string
    {
        return $this->workTuEnd;
    }

    /**
     * @param string $workTuEnd
     */
    public function setWorkTuEnd(string $workTuEnd): void
    {
        $this->workTuEnd = $workTuEnd;
    }

    /**
     * @return string
     */
    public function getWorkWeBegin(): string
    {
        return $this->workWeBegin;
    }

    /**
     * @param string $workWeBegin
     */
    public function setWorkWeBegin(string $workWeBegin): void
    {
        $this->workWeBegin = $workWeBegin;
    }

    /**
     * @return string
     */
    public function getWorkWeEnd(): string
    {
        return $this->workWeEnd;
    }

    /**
     * @param string $workWeEnd
     */
    public function setWorkWeEnd(string $workWeEnd): void
    {
        $this->workWeEnd = $workWeEnd;
    }

    /**
     * @return string
     */
    public function getWorkThBegin(): string
    {
        return $this->workThBegin;
    }

    /**
     * @param string $workThBegin
     */
    public function setWorkThBegin(string $workThBegin): void
    {
        $this->workThBegin = $workThBegin;
    }

    /**
     * @return string
     */
    public function getWorkThEnd(): string
    {
        return $this->workThEnd;
    }

    /**
     * @param string $workThEnd
     */
    public function setWorkThEnd(string $workThEnd): void
    {
        $this->workThEnd = $workThEnd;
    }

    /**
     * @return string
     */
    public function getWorkFrBegin(): string
    {
        return $this->workFrBegin;
    }

    /**
     * @param string $workFrBegin
     */
    public function setWorkFrBegin(string $workFrBegin): void
    {
        $this->workFrBegin = $workFrBegin;
    }

    /**
     * @return string
     */
    public function getWorkFrEnd(): string
    {
        return $this->workFrEnd;
    }

    /**
     * @param string $workFrEnd
     */
    public function setWorkFrEnd(string $workFrEnd): void
    {
        $this->workFrEnd = $workFrEnd;
    }

    /**
     * @return string
     */
    public function getWorkSaBegin(): string
    {
        return $this->workSaBegin;
    }

    /**
     * @param string $workSaBegin
     */
    public function setWorkSaBegin($workSaBegin): void
    {
        $this->workSaBegin = $workSaBegin;
    }

    /**
     * @return string
     */
    public function getWorkSaEnd(): string
    {
        return $this->workSaEnd;
    }

    /**
     * @param string $workSaEnd
     */
    public function setWorkSaEnd(string $workSaEnd): void
    {
        $this->workSaEnd = $workSaEnd;
    }

    /**
     * @return string
     */
    public function getWorkSuBegin(): string
    {
        return $this->workSuBegin;
    }

    /**
     * @param string $workSuBegin
     */
    public function setWorkSuBegin(string $workSuBegin): void
    {
        $this->workSuBegin = $workSuBegin;
    }

    /**
     * @return string
     */
    public function getWorkSuEnd(): string
    {
        return $this->workSuEnd;
    }

    /**
     * @param string $workSuEnd
     */
    public function setWorkSuEnd(string $workSuEnd): void
    {
        $this->workSuEnd = $workSuEnd;
    }

    /**
     * @return string
     */
    public function getLunchMoBegin(): string
    {
        return $this->lunchMoBegin;
    }

    /**
     * @param string $lunchMoBegin
     */
    public function setLunchMoBegin(string $lunchMoBegin): void
    {
        $this->lunchMoBegin = $lunchMoBegin;
    }

    /**
     * @return string
     */
    public function getLunchMoEnd(): string
    {
        return $this->lunchMoEnd;
    }

    /**
     * @param string $lunchMoEnd
     */
    public function setLunchMoEnd(string $lunchMoEnd): void
    {
        $this->lunchMoEnd = $lunchMoEnd;
    }

    /**
     * @return string
     */
    public function getLunchTuBegin(): string
    {
        return $this->lunchTuBegin;
    }

    /**
     * @param string $lunchTuBegin
     */
    public function setLunchTuBegin(string $lunchTuBegin): void
    {
        $this->lunchTuBegin = $lunchTuBegin;
    }

    /**
     * @return string
     */
    public function getLunchTuEnd(): string
    {
        return $this->lunchTuEnd;
    }

    /**
     * @param string $lunchTuEnd
     */
    public function setLunchTuEnd(string $lunchTuEnd): void
    {
        $this->lunchTuEnd = $lunchTuEnd;
    }

    /**
     * @return string
     */
    public function getLunchWeBegin(): string
    {
        return $this->lunchWeBegin;
    }

    /**
     * @param string $lunchWeBegin
     */
    public function setLunchWeBegin(string $lunchWeBegin): void
    {
        $this->lunchWeBegin = $lunchWeBegin;
    }

    /**
     * @return string
     */
    public function getLunchWeEnd(): string
    {
        return $this->lunchWeEnd;
    }

    /**
     * @param string $lunchWeEnd
     */
    public function setLunchWeEnd(string $lunchWeEnd): void
    {
        $this->lunchWeEnd = $lunchWeEnd;
    }

    /**
     * @return string
     */
    public function getLunchThBegin(): string
    {
        return $this->lunchThBegin;
    }

    /**
     * @param string $lunchThBegin
     */
    public function setLunchThBegin(string $lunchThBegin): void
    {
        $this->lunchThBegin = $lunchThBegin;
    }

    /**
     * @return string
     */
    public function getLunchThEnd(): string
    {
        return $this->lunchThEnd;
    }

    /**
     * @param string $lunchThEnd
     */
    public function setLunchThEnd(string $lunchThEnd): void
    {
        $this->lunchThEnd = $lunchThEnd;
    }

    /**
     * @return string
     */
    public function getLunchFrBegin(): string
    {
        return $this->lunchFrBegin;
    }

    /**
     * @param string $lunchFrBegin
     */
    public function setLunchFrBegin(string $lunchFrBegin): void
    {
        $this->lunchFrBegin = $lunchFrBegin;
    }

    /**
     * @return string
     */
    public function getLunchFrEnd(): string
    {
        return $this->lunchFrEnd;
    }

    /**
     * @param string $lunchFrEnd
     */
    public function setLunchFrEnd(string $lunchFrEnd): void
    {
        $this->lunchFrEnd = $lunchFrEnd;
    }

    /**
     * @return string
     */
    public function getLunchSaBegin(): string
    {
        return $this->lunchSaBegin;
    }

    /**
     * @param string $lunchSaBegin
     */
    public function setLunchSaBegin(string $lunchSaBegin): void
    {
        $this->lunchSaBegin = $lunchSaBegin;
    }

    /**
     * @return string
     */
    public function getLunchSaEnd(): string
    {
        return $this->lunchSaEnd;
    }

    /**
     * @param string $lunchSaEnd
     */
    public function setLunchSaEnd(string $lunchSaEnd): void
    {
        $this->lunchSaEnd = $lunchSaEnd;
    }

    /**
     * @return string
     */
    public function getLunchSuBegin(): string
    {
        return $this->lunchSuBegin;
    }

    /**
     * @param string $lunchSuBegin
     */
    public function setLunchSuBegin(string $lunchSuBegin): void
    {
        $this->lunchSuBegin = $lunchSuBegin;
    }

    /**
     * @return string
     */
    public function getLunchSuEnd(): string
    {
        return $this->lunchSuEnd;
    }

    /**
     * @param string $lunchSuEnd
     */
    public function setLunchSuEnd(string $lunchSuEnd): void
    {
        $this->lunchSuEnd = $lunchSuEnd;
    }

    /**
     * @return array
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /**
     * @param array $photos
     */
    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

    /**
     * @return string
     */
    public function getTerminalCode()
    {
        return $this->terminalCode;
    }

    /**
     * @param string $terminalCode
     */
    public function setTerminalCode(string $terminalCode): void
    {
        $this->terminalCode = $terminalCode;
    }

    /**
     * @return string
     */
    public function getTerminalName(): string
    {
        return $this->terminalName;
    }

    /**
     * @param string $terminalName
     */
    public function setTerminalName(string $terminalName): void
    {
        $this->terminalName = $terminalName;
    }

    /**
     * @return string
     */
    public function getTerminalOrganization(): string
    {
        return $this->terminalOrganization;
    }

    /**
     * @param string $terminalOrganization
     */
    public function setTerminalOrganization(string $terminalOrganization): void
    {
        $this->terminalOrganization = $terminalOrganization;
    }

    /**
     * @return string
     */
    public function getTerminalCityCode(): string
    {
        return $this->terminalCityCode;
    }

    /**
     * @param string $terminalCityCode
     */
    public function setTerminalCityCode(string $terminalCityCode): void
    {
        $this->terminalCityCode = $terminalCityCode;
    }

    /**
     * @return string
     */
    public function getTerminalCityName(): string
    {
        return $this->terminalCityName;
    }

    /**
     * @param string $terminalCityName
     */
    public function setTerminalCityName(string $terminalCityName): void
    {
        $this->terminalCityName = $terminalCityName;
    }

    /**
     * @return string
     */
    public function getTerminalAddress(): string
    {
        return $this->terminalAddress;
    }

    /**
     * @param string $terminalAddress
     */
    public function setTerminalAddress(string $terminalAddress): void
    {
        $this->terminalAddress = $terminalAddress;
    }

    /**
     * @return string
     */
    public function getTerminalPhone(): string
    {
        return $this->terminalPhone;
    }

    /**
     * @param string $terminalPhone
     */
    public function setTerminalPhone(string $terminalPhone): void
    {
        $this->terminalPhone = $terminalPhone;
    }

    /**
     * @return string
     */
    public function getReception(): string
    {
        return $this->reception;
    }

    /**
     * @param string $reception
     */
    public function setReception(string $reception): void
    {
        $this->reception = $reception;
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