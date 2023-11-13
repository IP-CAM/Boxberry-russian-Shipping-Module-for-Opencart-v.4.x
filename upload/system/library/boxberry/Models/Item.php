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
 *  * File: Item.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class Item
 * @package Boxberry\Models
 *
 * @var array  $propNameMap
 * @var string $id
 * @var string $name
 * @var string $unitName
 * @var string $nds
 * @var string $price
 * @var string $quantity
 * @var string $weight
 */
class Item extends AbstractModel
{
    protected array $propNameMap = array(
        'id'       => 'id',
        'name'     => 'name',
        'Unitname' => 'unitName',
        'nds'      => 'nds',
        'price'    => 'price',
        'quantity' => 'quantity'
    );
    protected string $id       = '';
    protected string $name     = '';
    protected string $unitName = '';
    protected string $nds      = '';
    protected string $price    = '';
    protected string $quantity = '';
    protected string $weight   = '';

    /**
     * @return array
     */
    public function getPropNameMap(): array
    {
        return $this->propNameMap;
    }

    /**
     * @param array $propNameMap
     */
    public function setPropNameMap(array $propNameMap): void
    {
        $this->propNameMap = $propNameMap;
    }

    /**
     * @return string
     */
    public function getWeight(): string
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     */
    public function setWeight(string $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUnitName(): string
    {
        return $this->unitName;
    }

    /**
     * @param string $unitName
     */
    public function setUnitName(string $unitName): void
    {
        $this->unitName = $unitName;
    }

    /**
     * @return string
     */
    public function getNds(): string
    {
        return $this->nds;
    }

    /**
     * @param string $nds
     */
    public function setNds(string $nds): void
    {
        $this->nds = $nds;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity(string $quantity): void
    {
        $this->quantity = $quantity;
    }
}