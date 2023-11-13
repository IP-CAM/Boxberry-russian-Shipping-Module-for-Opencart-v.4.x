<?php

namespace Boxberry\Models;

use Exception;

/**
 * Class DadataSuggestions
 * @package Boxberry\Models
 *
 * @var string $area
 * @var string $street
 * @var string $house
 * @var string $flat
 */
class DadataSuggestions extends AbstractModel
{
    protected string $area   = '';
    protected string $street = '';
    protected string $house  = '';
    protected string $flat   = '';

    /**
     * @throws Exception
     */
    public function __construct($data)
    {
        if (!isset($data['suggestions'][0]['data'])) {
            throw new Exception('Данные не найдены');
        }

        $data = $data['suggestions'][0]['data'];

        $this->area   = $data['region'];
        $this->street = $data['street'];
        $this->house  = $data['house'];
        $this->flat   = $data['flat'] ?? '';

        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getArea(): string
    {
        return $this->area;
    }

    /**
     * @param string $area
     */
    public function setArea(string $area): void
    {
        $this->area = $area;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getHouse(): string
    {
        return $this->house;
    }

    /**
     * @param string $house
     */
    public function setHouse(string $house): void
    {
        $this->house = $house;
    }

    /**
     * @return string
     */
    public function getFlat(): string
    {
        return $this->flat;
    }

    /**
     * @param string $flat
     */
    public function setFlat(string $flat): void
    {
        $this->flat = $flat;
    }
}