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
 *  * File: Request.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Абстрактный класс, от него унаследуются все запросы.
 * Class Request
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var string $propNameMap
 * @var string $method
 */
abstract class Request
{
    protected string $resultClass = '';
    protected array  $propNameMap = array();
    public    string $method      = 'GET';

    /**
     * @return string
     */
    public function getResultClass(): string
    {
        return $this->resultClass;
    }

    /**
     * @return array
     */
    public function getPropNameMap(): array
    {
        return $this->propNameMap;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        $path = explode('\\', get_class($this));

        return str_replace('Request', '', array_pop($path));
    }

    /**
     * @return bool
     */
    abstract function checkRequiredFields(): bool;
}