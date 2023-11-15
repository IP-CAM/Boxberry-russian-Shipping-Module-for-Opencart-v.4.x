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
 *  * File: ListStatusesRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Class ListStatusesRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $imId
 */
class ListStatusesRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Collections\\ListStatusesCollection';
    protected array  $propNameMap = array(
        'ImId' => 'imId'
    );
    public    string $method      = 'GET';
    protected string $imId        = '';

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

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        if ($this->getImId() === '') {
            return false;
        }
        return true;
    }
}