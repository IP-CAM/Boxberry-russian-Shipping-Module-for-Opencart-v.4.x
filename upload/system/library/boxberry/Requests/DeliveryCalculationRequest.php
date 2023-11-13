<?php

namespace Boxberry\Requests;

/**
 * Class DeliveryCalculationRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $senderCityId
 * @var string $recipientCityId
 * @var string $deliveryType
 * @var float  $orderSum
 * @var float  $paySum
 * @var string $zip
 * @var array  $boxSizes
 * @var int    $width
 * @var int    $height
 * @var int    $depth
 * @var int    $weight
 * @var string $useShopSettings
 * @var string $cmsName
 * @var string $url
 * @var string $version
 */
class DeliveryCalculationRequest extends Request
{
    protected string $resultClass     = 'Boxberry\\Models\\DeliveryCalculation';
    protected array  $propNameMap     = array(
        'SenderCityId'     => 'senderCityId',
        'RecipientCityId'  => 'recipientCityId',
        'DeliveryType'     => 'deliveryType',
        'OrderSum'         => 'orderSum',
        'PaySum'           => 'paySum',
        'Zip'              => 'zip',
        'BoxSizes'         => 'boxSizes',
        'UseShopSettings'  => 'useShopSettings',
        'CmsName'          => 'cmsName',
        'Url'              => 'url',
        'Version'          => 'version'
    );
    public    string $method          = 'POST';
    protected string $senderCityId    = '';
    protected string $recipientCityId = '';
    protected string $deliveryType    = '';
    protected float  $orderSum        = 0;
    protected float  $paySum          = 0;
    protected string $zip             = '';
    protected array  $boxSizes        = array();
    protected int    $width           = 0;
    protected int    $height          = 0;
    protected int    $depth           = 0;
    protected int    $weight          = 0;
    protected string $useShopSettings = '';
    protected string $cmsName         = '';
    protected string $url             = '';
    protected string $version         = '';

    /**
     * @return string
     */
    public function getSenderCityId(): string
    {
        return $this->senderCityId;
    }

    /**
     * @param string $senderCityId
     */
    public function setSenderCityId(string $senderCityId): void
    {
        $this->senderCityId = $senderCityId;
    }

    /**
     * @return string
     */
    public function getRecipientCityId(): string
    {
        return $this->recipientCityId;
    }

    /**
     * @param string $recipientCityId
     */
    public function setRecipientCityId(string $recipientCityId): void
    {
        $this->recipientCityId = $recipientCityId;
    }

    /**
     * @return string
     */
    public function getDeliveryType(): string
    {
        return $this->deliveryType;
    }

    /**
     * @param string $deliveryType
     */
    public function setDeliveryType(string $deliveryType): void
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return float
     */
    public function getOrderSum(): float
    {
        return $this->orderSum;
    }

    /**
     * @param float $orderSum
     */
    public function setOrderSum(float $orderSum): void
    {
        $this->orderSum = $orderSum;
    }

    /**
     * @return float
     */
    public function getPaySum(): float
    {
        return $this->paySum;
    }

    /**
     * @param float $paySum
     */
    public function setPaySum(float $paySum): void
    {
        $this->paySum = $paySum;
    }

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
     * @return array
     */
    public function getBoxSizes(): array
    {
        return $this->boxSizes;
    }

    public function setBoxSizes(): void
    {
        $this->boxSizes = array(
            array(
                'Width'  => $this->width,
                'Height' => $this->height,
                'Depth'  => $this->depth,
                'Weight' => $this->weight
            )
        );
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     */
    public function setDepth(int $depth): void
    {
        $this->depth = $depth;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getUseShopSettings(): string
    {
        return $this->useShopSettings;
    }

    /**
     * @param string $useShopSettings
     */
    public function setUseShopSettings(string $useShopSettings): void
    {
        $this->useShopSettings = $useShopSettings;
    }

    /**
     * @return string
     */
    public function getCmsName(): string
    {
        return $this->cmsName;
    }

    /**
     * @param string $cmsName
     */
    public function setCmsName(string $cmsName): void
    {
        $this->cmsName = $cmsName;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    function checkRequiredFields(): bool
    {
        if (!$this->recipientCityId) {
            return false;
        }

        if (!$this->boxSizes) {
            return false;
        }

        if (!$this->weight) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }
}