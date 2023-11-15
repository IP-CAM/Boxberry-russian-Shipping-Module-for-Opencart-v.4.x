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
 *  * File: ParselSendRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

use Boxberry\Collections\Exceptions\BadValueException;
use Boxberry\Collections\ImgIdsCollection;

/**
 * Class ParselSendRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 * @var array  $propNameMap
 * @var string $method
 * @var ImgIdsCollection $imgIdsList
 */
class ParselSendRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Client\\ParselSendResponse';
    protected array  $propNameMap = array(
        'ImIds' => 'imgIdsList'
    );
    public    string $method      = 'GET';
    protected ImgIdsCollection $imgIdsList;

    /**
     * @return string
     */
    public function getImgIdsList(): string
    {
        $array = iterator_to_array($this->imgIdsList, false);
        return implode(',', $array);
    }

    /**
     * @param $imgIdsList
     * @throws BadValueException
     */
    public function setImgIdsList($imgIdsList): void
    {
        if ($imgIdsList instanceof ImgIdsCollection) {
            $this->imgIdsList = $imgIdsList;
        } elseif (is_array($imgIdsList)) {
            $this->imgIdsList = new ImgIdsCollection($imgIdsList);
        } else {
            throw new BadValueException;
        }
    }

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        if (empty($this->imgIdsList)) {
            return false;
        }
        return true;
    }
}