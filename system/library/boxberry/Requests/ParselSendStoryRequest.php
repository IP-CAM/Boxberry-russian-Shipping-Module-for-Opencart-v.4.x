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
 *  * File: ParselSendStoryRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

use Boxberry\Collections\Exceptions\BadValueException;

/**
 * Class ParselSendStoryRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $from
 * @var string $to
 */
class ParselSendStoryRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Client\\ParselCheckResponse';
    protected array  $propNameMap = array(
        'from' => 'from',
        'to'   => 'to'
    );
    public    string $method      = 'GET';
    protected string $from        = '';
    protected string $to          = '';

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @throws BadValueException
     */
    public function setFrom(string $from): void
    {
        $timeUnix = strtotime($from);
        if ($timeUnix === false) {
            throw new BadValueException;
        }
        $this->from = date('Ymd');
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     * @throws BadValueException
     */
    public function setTo(string $to): void
    {
        $timeUnix = strtotime($to);
        if ($timeUnix === false) {
            throw new BadValueException;
        }
        $this->from = date('Ymd');
    }

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        return true;
    }
}