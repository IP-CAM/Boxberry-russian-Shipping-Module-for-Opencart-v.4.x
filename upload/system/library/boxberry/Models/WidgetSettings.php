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
 *  * File: WidgetSettings.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class WidgetSettings
 * @package Boxberry\Models
 *
 * @var array $result
 * @var int   $type
 * @var bool  $prepaid
 * @var array $CityCode
 * @var array $Code
 * @var int   $hide_delivery_day
 * @var int   $add_delivery_day
 */
class WidgetSettings extends AbstractModel
{
    protected array $result            = array();
    protected int   $type              = 0;
    protected bool  $prepaid           = false;
    protected array $CityCode          = array();
    protected array $Code              = array();
    protected int   $hide_delivery_day = 0;
    protected int   $add_delivery_day  = 0;

	public function __construct($data = null)
    {
        if ($data) {
            if (isset($data['result'][3])) {
                $this->hide_delivery_day = $data['result'][3]['hide_delivery_day'];
                $this->add_delivery_day  = $data['result'][3]['add_delivery_day'];
            }
            $this->result = $data['result'];
        }
        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return bool
     */
    public function getPrepaid(): bool
    {
        return $this->prepaid;
    }

    /**
     * @param string $prepaid
     */
    public function setPrepaid(string $prepaid): void
    {
        $this->prepaid = $prepaid;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
   	public function getCityCode(): array
    {
        return $this->CityCode;
    }

    /**
     * @param array $CityCode
     */
    public function setCityCode(array $CityCode): void
    {
        $this->CityCode = $CityCode;
    }

	/**
    * @return array
    */
   	public function getCode(): array
    {
        return $this->Code;
    }

    /**
     * @param array $Code
     */
    public function setCode(array $Code): void
    {
        $this->Code = $Code;
    }

	/**
    * @return int
    */
   	public function getHide_delivery_day(): int
    {
        return $this->hide_delivery_day;
    }

    /**
     * @param int $hide_delivery_day
     */
    public function setHide_delivery_day(int $hide_delivery_day): void
    {
        $this->hide_delivery_day = $hide_delivery_day;
    }

	/**
    * @return int
    */
   	public function getAdd_delivery_day(): int
    {
        return $this->add_delivery_day;
    }

    /**
     * @param int $add_delivery_day
     */
    public function setAdd_delivery_day(int $add_delivery_day): void
    {
        $this->add_delivery_day = $add_delivery_day;
    }
}