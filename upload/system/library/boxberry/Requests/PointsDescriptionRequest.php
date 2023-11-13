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
 *  * File: PointsDescriptionRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Class PointsDescriptionRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $code
 * @var int    $photo
 */
class PointsDescriptionRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Models\\Point';
    protected array  $propNameMap = array(
        'code'  => 'code',
        'photo' => 'photo'
    );
    public    string $method      = 'GET';
    protected string $code        = '';
    protected int    $photo       = 0;

    /**
     * @return string
     */
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
     * @return int
     */
    public function getPhoto(): int
    {
        return $this->photo;
    }

    /**
     * @param int $photo
     */
    public function setPhoto(int $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        if ($this->code === '') {
           return false;
        }
        return true;
    }
}