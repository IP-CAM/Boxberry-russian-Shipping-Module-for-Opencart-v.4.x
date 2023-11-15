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
 *  * File: PointsForParcelsRequest.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Requests;

/**
 * Class PointsForParcelsRequest
 * @package Boxberry\Requests
 *
 * @var string $resultClass
 */
class PointsForParcelsRequest extends Request
{
    protected string $resultClass = 'Boxberry\\Models\\ShortPoint';

    /**
     * @return bool
     */
    function checkRequiredFields(): bool
    {
        return true;
    }
}