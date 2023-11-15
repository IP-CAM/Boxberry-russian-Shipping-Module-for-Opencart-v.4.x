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
 *  * File: Product.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class Product
 * @package Boxberry\Models
 *
 * @var string $name
 * @var string $give
 * @var string $return
 */
class Product extends AbstractModel
{
    protected string $name   = '';
    protected string $give   = '';
    protected string $return = '';

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
    public function getGive(): string
    {
        return $this->give;
    }

    /**
     * @param string $give
     */
    public function setGive(string $give): void
    {
        $this->give = $give;
    }

    /**
     * @return string
     */
    public function getReturn(): string
    {
        return $this->return;
    }

    /**
     * @param string $return
     */
    public function setReturn(string $return): void
    {
        $this->return = $return;
    }
}