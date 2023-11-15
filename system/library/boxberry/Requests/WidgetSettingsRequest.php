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
 *  * File: WidgetSettingsRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Class WidgetSettingsRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var int    $type
 */
class WidgetSettingsRequest extends Request
{
    protected string $resultClass = 'Boxberry\Models\WidgetSettings';
    protected array  $propNameMap = array(
        'Prepaid'           => 'prepaid',
        'CityCode'          => 'CityCode',
        'Code'              => 'Code',
        'Hide_delivery_day' => 'hide_delivery_day',
        'Add_delivery_day'  => 'add_delivery_day',
        'type'              => 'type'
    );
    public    string $method      = 'GET';
    protected int    $type        = 3;

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
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        return true;
    }
}