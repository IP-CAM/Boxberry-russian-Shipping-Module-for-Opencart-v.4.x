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
 *  * File: HTTP.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Client;

use Boxberry\Client\Exceptions\BadResponseException;
use Exception;
use HttpException;
use Boxberry\Logger\Logger;

/**
 * Class HTTP
 * @package Boxberry\Client
 *
 * @var string $log_path
 * @var array  $methods_disable_log_response
 */
class HTTP
{
    protected static string $log_path = DIR_LOGS . 'api_boxberry';
    protected static array $methods_disable_log_response = array(
        'ListCities',
        'ListCitiesFull',
        'ListZips',
        'ListPoints',
        'ListPointsShort',
        'PointsForParcels',
        'PointsByPostCode',
        'CourierListCities'
    );

    /**
     * @param $api_url
     * @param $args
     * @return Response
     * @throws HttpException|BadResponseException
     */
    static function get($api_url, $args): Response
    {
        return self::send('GET', $api_url, $args);
    }

    /**
     * @param $api_url
     * @param $args
     * @param array $headers
     * @return Response
     * @throws BadResponseException
     * @throws HttpException
     */
    static function post($api_url, $args, array $headers = []): Response
    {
        return self::send('POST', $api_url, $args, $headers);
    }

    /**
     * @param $method
     * @param $api_url
     * @param $args
     * @param array $headers
     * @return Response
     * @throws BadResponseException
     * @throws HttpException
     * @throws Exception
     */
    static private function send($method, $api_url, $args, array $headers = []): Response
    {
        $logger = new Logger(self::$log_path);
        if ($curl = curl_init()) {
            $logger->info('Request: ', [$method, $api_url, $args]);
            if ($method == 'GET') {
                curl_setopt($curl, CURLOPT_URL, $api_url . (is_array($args) && !empty($args) ? '?' . http_build_query($args) : ''));
            } elseif ($method == 'POST') {
                if (!empty($headers)) {
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                }
                curl_setopt($curl, CURLOPT_URL, $api_url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($args, JSON_UNESCAPED_UNICODE));
            }
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $errno = curl_errno($curl);
            $error = curl_error($curl);
            $out = curl_exec($curl);

            curl_close($curl);

            if ($errno) {
                $logger->error("Error Response: ", $error);
                throw new Exception($error);
            }

            if (!$answer = json_decode($out, true)) {
                $logger->error("Invalid JSON Response: ", [$out]);
                throw new BadResponseException("Ошибка обращения к сервису доставки Boxberry");
            }

            if (isset($answer['err'])) {
                $logger->error("Error Response: ", $answer);
                throw new BadResponseException($answer['err']);
            }
            if (isset($answer[0]['err'])) {
                $logger->error("Error Response: ", $answer);
                throw new BadResponseException($answer[0]['err']);
            }
            if (isset($args['method']) && !in_array($args['method'], self::$methods_disable_log_response)) {
                $logger->info('Response: ', $answer);
            }

            return new Response($answer);
        } else {
            $logger->info('Can not create connection to ' . $api_url, [$method, $api_url, $args]);
            throw new HttpException('Can not create connection to ' . $api_url . ' with args ' . $args, 404);
        }
    }
}