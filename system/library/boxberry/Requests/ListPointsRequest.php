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
 *  * File: ListPointsRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Class ListPointsRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $cityCode
 * @var int    $prepaid
 */
class ListPointsRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Collections\\ListPointsCollection';
    protected array  $propNameMap = array(
        'CityCode' => 'cityCode',
        'prepaid'  => 'prepaid'
    );
    public    string $method      = 'GET';
    protected string $cityCode    = '';
    protected int    $prepaid     = 0;

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
     * @return int
     */
    public function getPrepaid(): int
    {
        return $this->prepaid;
    }
    /**
     * @param int $prepaid
     */
    public function setPrepaid(int $prepaid): void
    {
        $this->prepaid = $prepaid;
    }

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        return true;
    }
}