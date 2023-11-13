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
 *  * File: ParselCreateRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

use Boxberry\Models\Parsel;

/**
 * Class ParselCreateRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var Parsel $parsel
 */
class ParselCreateRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Client\\ParselCreateResponse';
    protected array  $propNameMap = array(
        'root' => 'parsel'
    );
    public    string $method      = 'POST';
    protected Parsel $parsel;

    /**
     * @return Parsel
     */
    public function getParsel(): Parsel
    {
        return $this->parsel;
    }
    /**
     * @param Parsel $parsel
     */
    public function setParsel(Parsel $parsel): void
    {
        $this->parsel = $parsel;
    }

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        if (empty($this->getParsel())) {
            return false;
        }
        return true;
    }
}