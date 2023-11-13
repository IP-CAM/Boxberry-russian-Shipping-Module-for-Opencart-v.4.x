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
 *  * File: ParselStory.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class ParselStory
 * @package Boxberry\Models
 *
 * @var string $track
 * @var string $label
 * @var string $date
 * @var bool   $send
 * @var string $barcode
 * @var string $imId
 */
class ParselStory extends AbstractModel
{
    protected string $track   = '';
    protected string $label   = '';
    protected string $date    = '';
    protected bool   $send    = false;
    protected string $barcode = '';
    protected string $imId    = '';

    /**
     * @return string
     */
    public function getTrack(): string
    {
        return $this->track;
    }

    /**
     * @param string $track
     */
    public function setTrack(string $track): void
    {
        $this->track = $track;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return boolean
     */
    public function isSend(): bool
    {
        return $this->send;
    }

    /**
     * @param boolean $send
     */
    public function setSend(bool $send): void
    {
        $this->send = $send;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode(string $barcode): void
    {
        $this->barcode = $barcode;
    }

    /**
     * @return string
     */
    public function getImId(): string
    {
        return $this->imId;
    }

    /**
     * @param string $imId
     */
    public function setImId(string $imId): void
    {
        $this->imId = $imId;
    }
}