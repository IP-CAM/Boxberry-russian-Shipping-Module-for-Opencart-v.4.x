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
 *  * File: FullStatusesResponse.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Client;

use Boxberry\Client\Exceptions\BadResponseException;
use Boxberry\Collections\Exceptions\BadValueException;
use Boxberry\Collections\ListProductsCollection;
use Boxberry\Collections\ListStatusesCollection;

/**
 * Class FullStatusesResponse
 * @package Boxberry\Client
 *
 * @var ListStatusesCollection $statuses
 * @var ListProductsCollection $products
 * @var bool $PD
 */
class FullStatusesResponse
{
    protected ListStatusesCollection $statuses;
    protected ListProductsCollection $products;
    protected bool $PD = false; // Признак частичной выдачи заказа

    /**
     * FullStatusesResponse constructor.
     * @param array $data
     * @throws BadResponseException|BadValueException
     */
    public function __construct(array $data)
    {
        if (isset($data['statuses']) && is_array($data['statuses'])) {
            $this->statuses = new ListStatusesCollection($data['statuses']);
        } else {
            throw new BadResponseException;
        }
        if (isset($data['products']) && is_array($data['products'])) {
            $this->products = new ListProductsCollection($data['products']);
        } else {
            throw new BadResponseException;
        }
        if (isset($data['PD'])) {
            $this->PD = $data['PD'];
        } else {
            throw new BadResponseException;
        }
    }

    /**
     * @return ListStatusesCollection
     */
    public function getStatuses(): ListStatusesCollection
    {
        return $this->statuses;
    }

    /**
     * @param ListStatusesCollection $statuses
     */
    public function setStatuses(ListStatusesCollection $statuses): void
    {
        $this->statuses = $statuses;
    }

    /**
     * @return ListProductsCollection
     */
    public function getProducts(): ListProductsCollection
    {
        return $this->products;
    }

    /**
     * @param ListProductsCollection $products
     */
    public function setProducts(ListProductsCollection $products): void
    {
        $this->products = $products;
    }

    /**
     * @return bool
     */
    public function getPD(): bool
    {
        return $this->PD;
    }

    /**
     * @param bool $PD
     */
    public function setPD(bool $PD): void
    {
        $this->PD = $PD;
    }
}