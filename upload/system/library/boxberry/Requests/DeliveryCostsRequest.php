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
 *  * File: DeliveryCostsRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Class DeliveryCostsRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $weight
 * @var string $target
 * @var string $ordersum
 * @var string $deliverysum
 * @var string $targetstart
 * @var string $height
 * @var string $width
 * @var string $depth
 * @var string $zip
 * @var string $paysum
 * @var int    $surch
 * @var string $version
 * @var string $cms
 * @var string $url
 */
class DeliveryCostsRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Models\\DeliveryCosts';
    protected array  $propNameMap = array(
        'weight'      => 'weight',
        'target'      => 'target',
        'ordersum'    => 'ordersum',
        'deliverysum' => 'deliverysum',
        'targetstart' => 'targetstart',
        'height'      => 'height',
        'width'       => 'width',
        'depth'       => 'depth',
        'zip'         => 'zip',
        'paysum'      => 'paysum',
        'sucrh'       => 'surch',
        'version'     => 'version',
        'cms'         => 'cms',
        'url'         => 'url'
    );
    public    string $method      = 'GET';
    protected string $weight      = '';
    protected string $target      = '';
    protected string $ordersum    = '';
    protected string $deliverysum = '';
    protected string $targetstart = '';
    protected string $height      = '';
    protected string $width       = '';
    protected string $depth       = '';
    protected string $zip         = '';
    protected string $paysum      = '';
    protected int    $surch       = 1;
    protected string $version     = '';
    protected string $cms         = '';
    protected string $url         = '';

    /**
     * @return int
     */
    public function getSurch(): int
    {
        return $this->surch;
    }

    /**
     * @param int $surch
     */
    public function setSurch(int $surch): void
    {
        $this->surch = $surch;
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

    /**
     * @return string
     */
    public function getCms(): string
    {
        return $this->cms;
    }

    /**
     * @param string $cms
     */
    public function setCms(string $cms): void
    {
        $this->cms = $cms;
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
     * @return string
     */
    public function getWeight(): string
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     */
    public function setWeight(string $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getOrdersum(): string
    {
        return $this->ordersum;
    }

    /**
     * @param string $ordersum
     */
    public function setOrdersum(string $ordersum): void
    {
        $this->ordersum = $ordersum;
    }

    /**
     * @return string
     */
    public function getDeliverysum(): string
    {
        return $this->deliverysum;
    }

    /**
     * @param string $deliverysum
     */
    public function setDeliverysum(string $deliverysum): void
    {
        $this->deliverysum = $deliverysum;
    }

    /**
     * @return string
     */
    public function getTargetstart(): string
    {
        return $this->targetstart;
    }

    /**
     * @param string $targetstart
     */
    public function setTargetstart(string $targetstart): void
    {
        $this->targetstart = $targetstart;
    }

    /**
     * @return string
     */
    public function getHeight(): string
    {
        return $this->height;
    }

    /**
     * @param string $height
     */
    public function setHeight(string $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getWidth(): string
    {
        return $this->width;
    }

    /**
     * @param string $width
     */
    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    /**
     * @return string
     */
    public function getDepth(): string
    {
        return $this->depth;
    }

    /**
     * @param string $depth
     */
    public function setDepth(string $depth): void
    {
        $this->depth = $depth;
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
     * @return string
     */
    public function getPaysum(): string
    {
        return $this->paysum;
    }

    /**
     * @param string $paysum
     */
    public function setPaysum(string $paysum): void
    {
        $this->paysum = $paysum;
    }

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        if (($this->getWeight() === '') || (($this->getTarget() === '') && ($this->getZip() === ''))) {
            return false;
        }
        return true;
    }
}