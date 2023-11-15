<?php
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