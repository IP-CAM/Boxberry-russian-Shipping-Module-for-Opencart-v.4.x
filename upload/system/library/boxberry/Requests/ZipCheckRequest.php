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
 *  * File: ZipCheckRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Class ZipCheckRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var string $zip
 */
class ZipCheckRequest extends Request
{
    protected string $resultClass = 'Boxberry\Models\ShortZip';
    protected array  $propNameMap = array(
        'Zip' => 'zip'
    );
    public    string $method      = 'GET';
    protected string $zip         = '';

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        if ($this->zip === '') {
            return false;
        }
        return true;
    }
}