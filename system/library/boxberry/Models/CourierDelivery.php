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
 *  * File: CourierDelivery.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class CourierDelivery
 * @package Boxberry\Models
 *
 * @var array  $propNameMap
 * @var string $index
 * @var string $city
 * @var string $addressp
 * @var string $timesfrom1
 * @var string $timesto1
 * @var string $timesfrom2
 * @var string $timesto2
 * @var string $timep
 * @var string $commentk
 */
class CourierDelivery extends CourierDeliveryShort
{
    protected array $propNameMap = array(
        'index'      => 'index',
        'citi'       => 'city',
        'addressp'   => 'addressp',
        'timesfrom1' => 'timesfrom1',
        'timesfrom2' => 'timesfrom2',
        'timesto1'   => 'timesto1',
        'timesto2 '  => 'timesto2',
        'timep'      => 'timep',
        'commentk'   => 'commentk'
    );
    protected string $index      = '';
    protected string $city       = '';
    protected string $addressp   = '';
    protected string $timesfrom1 = '';
    protected string $timesto1   = '';
    protected string $timesfrom2 = '';
    protected string $timesto2   = '';
    protected string $timep      = '';
    protected string $commentk   = '';

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

    /**
     * @return string
     */
    public function getAddressp(): string
    {
        return $this->addressp;
    }

    /**
     * @param string $addressp
     */
    public function setAddressp(string $addressp): void
    {
        $this->addressp = $addressp;
    }

    /**
     * @return string
     */
    public function getTimesfrom1(): string
    {
        return $this->timesfrom1;
    }

    /**
     * @param string $timesfrom1
     */
    public function setTimesfrom1(string $timesfrom1): void
    {
        $this->timesfrom1 = $timesfrom1;
    }

    /**
     * @return string
     */
    public function getTimesto1(): string
    {
        return $this->timesto1;
    }

    /**
     * @param string $timesto1
     */
    public function setTimesto1(string $timesto1): void
    {
        $this->timesto1 = $timesto1;
    }

    /**
     * @return string
     */
    public function getTimesfrom2(): string
    {
        return $this->timesfrom2;
    }

    /**
     * @param string $timesfrom2
     */
    public function setTimesfrom2(string $timesfrom2): void
    {
        $this->timesfrom2 = $timesfrom2;
    }

    /**
     * @return string
     */
    public function getTimesto2(): string
    {
        return $this->timesto2;
    }

    /**
     * @param string $timesto2
     */
    public function setTimesto2(string $timesto2): void
    {
        $this->timesto2 = $timesto2;
    }

    /**
     * @return string
     */
    public function getTimep(): string
    {
        return $this->timep;
    }

    /**
     * @param string $timep
     */
    public function setTimep(string $timep): void
    {
        $this->timep = $timep;
    }

    /**
     * @return string
     */
    public function getCommentk(): string
    {
        return $this->commentk;
    }

    /**
     * @param string $commentk
     */
    public function setCommentk(string $commentk): void
    {
        $this->commentk = $commentk;
    }
}