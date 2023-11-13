<?php

namespace Boxberry\Requests;

/**
 * Class DadataSuggestionsRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $query
 * @var array  $locations
 */
class DadataSuggestionsRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Models\\DadataSuggestions';
    protected array  $propNameMap = array(
        'query'      => 'query',
        'locations'  => 'locations'
    );
    public    string $method      = 'POST';
    protected string $query       = '';
    protected array  $locations   = array();

    /**
     * @inheritDoc
     */
    function checkRequiredFields(): bool
    {
        if (empty(trim($this->query))){
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getLocations(): array
    {
        return $this->locations;
    }

    /**
     * @return void
     */
    public function setLocations(): void
    {
        $this->locations = array(
            'country' => '*',
        );
    }

    /**
     * @return void
     */
    public function fixCityName(): void
    {
        $this->query = str_replace('АЛМА-АТА', 'АЛМАТЫ', mb_strtoupper($this->query));
    }
}