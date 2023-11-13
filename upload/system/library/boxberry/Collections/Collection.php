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
 *  * File: Collection.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Collections;

use ArrayAccess, Countable, Iterator, Serializable, ArrayIterator;

/**
 * Абстрактная коллекция, служащая базой.
 * Class Collection
 * @package Boxberry\Collections
 *
 * @var array $_container
 * @var int   $_position
 */
abstract class Collection implements ArrayAccess, Countable, Iterator, Serializable
{
    protected array $_container = array();
    protected int   $_position  = 0;

    /**
     * Collection constructor.
     * @param $data
     */
    abstract function __construct($data);

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->_container[$offset]);
    }

    /**
     * @param mixed $offset
     * @return null
     */
    public function offsetGet(mixed $offset)
    {
        return $this->offsetExists($offset) ? $this->_container[$offset] : null;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->_container[$offset]);
    }

    /**
     *
     */
    public function rewind(): void
    {
        $this->_position = 0;
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->_container[$this->_position];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->_position;
    }

    /**
     *
     */
    public function next(): void
    {
        ++$this->_position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->_container[$this->_position]);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->_container);
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize($this->_container);
    }

    /**
     * @param string $data
     */
    public function unserialize(string $data): void
    {
        $this->_container = unserialize($data);
    }

    /**
     * @param array|null $data
     * @return array
     */
    public function __invoke(array $data = null): array
    {
        if (!is_null($data)) {
            $this->_container = $data;
        }
        return $this->_container;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this);
    }
}