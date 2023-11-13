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
 *  * File: ShortZip.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class ShortZip
 * @package Boxberry\Models
 *
 * @var string $expressDelivery
 * @var string $zoneExpressDelivery
 */
class ShortZip extends AbstractModel
{
    protected string $expressDelivery     = '';
    protected string $zoneExpressDelivery = '';

    /**
     * @return string
     */
    public function getExpressDelivery(): string
    {
        return $this->expressDelivery;
    }

    /**
     * @param string $expressDelivery
     */
    public function setExpressDelivery(string $expressDelivery): void
    {
        $this->expressDelivery = $expressDelivery;
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

}