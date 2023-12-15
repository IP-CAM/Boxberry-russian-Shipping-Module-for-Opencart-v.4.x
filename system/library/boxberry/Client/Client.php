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
 *  * File: Client.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Client;

use Boxberry\Client\Exceptions\BadSettingsException;
use Boxberry\Client\Exceptions\UnknownTypeException;
use Boxberry\Client\Exceptions\BadResponseException;
use Boxberry\Requests;
use Boxberry\Requests\DadataSuggestionsRequest;
use Boxberry\Requests\DeliveryCalculationRequest;
use Boxberry\Requests\Request;
use HttpException;

/**
 * Базовый класс, который создает объекты запросов и исполняет их.
 * Class Client
 * @package Boxberry\Client
 *
 * @var string $api_token
 * @var string $api_url
 * @var string $production_url
 * @var string $dadataApiUrl
 * @var string $dadataApiToken
 * @var bool   $debug_mode_enabled
 * @var string $debug_url
 */
class Client
{
    protected string $api_token          = '';
    protected string $api_url            = '';
    protected string $production_url     = 'https://api.boxberry.ru/json.php';
    protected string $dadataApiUrl       = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address';
    protected string $dadataApiToken     = 'Token a105367bc6479ffb2a355fad7536e0fb504c1b97';
    protected bool   $debug_mode_enabled = false;
    private   string $debug_url          = '';

    public function __construct()
    {
        $this->api_url = $this->production_url;
    }

    public function enableDebugMode(): void
    {
        $this->api_url = $this->debug_url;
        $this->debug_mode_enabled = true;
    }

    public function disableDebugMode(): void
    {
        $this->api_url = $this->production_url;
        $this->debug_mode_enabled = false;
    }

    public function isDebugModeEnabled(): bool
    {
        return $this->debug_mode_enabled;
    }

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return $this->api_token;
    }

    /**
     * @param string $api_token
     */
    public function setApiToken(string $api_token): void
    {
        $this->api_token = $api_token;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->api_url;
    }

    /**
     * @param string $api_url
     */
    public function setApiUrl(string $api_url): void
    {
        if ($this->isDebugModeEnabled()) {
            $this->debug_url = $api_url;
        } else {
            $this->production_url = $api_url;
        }
        $this->api_url = $api_url;
    }

    /**
     * @return array
     */
    public function getDadataHeaders(): array
    {
        return array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: ' . $this->dadataApiToken
        );
    }

    /**
     * @return DadataSuggestionsRequest
     */
    public function getDadataSuggestions(): DadataSuggestionsRequest
    {
        return new Requests\DadataSuggestionsRequest();
    }

    /**
     * @return DeliveryCalculationRequest
     */
    public function getDeliveryCalculation(): DeliveryCalculationRequest
    {
        return new Requests\DeliveryCalculationRequest();
    }

    /**
     * @return Requests\CourierListCitiesRequest
     */
    public static function getCourierListCities(): Requests\CourierListCitiesRequest
    {
        return new Requests\CourierListCitiesRequest();
    }

    /**
     * @return Requests\DeliveryCostsRequest
     */
    public static function getDeliveryCosts(): Requests\DeliveryCostsRequest
    {
        return new Requests\DeliveryCostsRequest();
    }

    /**
     * @return Requests\WidgetSettingsRequest
     */
    public static function getWidgetSettings(): Requests\WidgetSettingsRequest
    {
        return new Requests\WidgetSettingsRequest();
    }

    /**
     * @return Requests\GetKeyIntegration
     */
    public static function getKeyIntegration(): Requests\GetKeyIntegration
    {
        return new Requests\GetKeyIntegration();
    }

    /**
     * @return Requests\ListCitiesRequest
     */
    public static function getListCities(): Requests\ListCitiesRequest
    {
        return new Requests\ListCitiesRequest();
    }

    /**
     * @return Requests\ListCitiesFullRequest
     */
    public static function getListCitiesFull(): Requests\ListCitiesFullRequest
    {
        return new Requests\ListCitiesFullRequest();
    }

    /**
     * @return Requests\ListPointsRequest
     */
    public static function getListPoints(): Requests\ListPointsRequest
    {
        return new Requests\ListPointsRequest();
    }

    /**
     * @return Requests\ListServicesRequest
     */
    public static function getListServices(): Requests\ListServicesRequest
    {
        return new Requests\ListServicesRequest();
    }

    /**
     * @return Requests\ListStatusesRequest
     */
    public static function getListStatuses(): Requests\ListStatusesRequest
    {
        return new Requests\ListStatusesRequest();
    }

    /**
     * @return Requests\ListStatusesFullRequest
     */
    public static function getListStatusesFull(): Requests\ListStatusesFullRequest
    {
        return new Requests\ListStatusesFullRequest();
    }

    /**
     * @return Requests\ListZipsRequest
     */
    public static function getListZips(): Requests\ListZipsRequest
    {
        return new Requests\ListZipsRequest();
    }

    /**
     * @return Requests\ZipCheckRequest
     */
    public static function getZipCheck(): Requests\ZipCheckRequest
    {
        return new Requests\ZipCheckRequest();
    }

    /**
     * @return Requests\ParselCheckRequest
     */
    public static function getParselCheck(): Requests\ParselCheckRequest
    {
        return new Requests\ParselCheckRequest();
    }

    /**
     * @return Requests\ParselCreateRequest
     */
    public static function getParselCreate(): Requests\ParselCreateRequest
    {
        return new Requests\ParselCreateRequest();
    }

    /**
     * @return Requests\ParselDelRequest
     */
    public static function getParselDel(): Requests\ParselDelRequest
    {
        return new Requests\ParselDelRequest();
    }

    /**
     * @return Requests\ParselListRequest
     */
    public static function getParselList(): Requests\ParselListRequest
    {
        return new Requests\ParselListRequest();
    }

    /**
     * @return Requests\ParselSendRequest
     */
    public static function getParselSend(): Requests\ParselSendRequest
    {
        return new Requests\ParselSendRequest();
    }

    /**
     * @return Requests\ParselSendStoryRequest
     */
    public static function getParselSendStory(): Requests\ParselSendStoryRequest
    {
        return new Requests\ParselSendStoryRequest();
    }

    /**
     * @return Requests\ParselStoryRequest
     */
    public static function getParselStory(): Requests\ParselStoryRequest
    {
        return new Requests\ParselStoryRequest();
    }

    /**
     * @return Requests\PointsByPostcodeRequest
     */
    public static function getPointsByPostCode(): Requests\PointsByPostcodeRequest
    {
        return new Requests\PointsByPostcodeRequest();
    }

    /**
     * @return Requests\PointsDescriptionRequest
     */
    public static function getPointsDescription(): Requests\PointsDescriptionRequest
    {
        return new Requests\PointsDescriptionRequest();
    }

    /**
     * @return Requests\PointsForParcelsRequest
     */
    public static function getPointsForParcels(): Requests\PointsForParcelsRequest
    {
        return new Requests\PointsForParcelsRequest();
    }

    /**
     * Проверяет правильно ли заполнен request, подготавливает запрос для отправки.
     * Возвращается тип, который ожидался в нужном request.
     * @param Request $request
     * @return Object|bool
     * @throws BadSettingsException
     * @throws Requests\Exceptions\RequiredFieldsNullException
     * @throws UnknownTypeException|HttpException|BadResponseException
     */
    public function execute(Request $request): object|bool
    {
        if ($this->api_url === '' || $this->api_token === '') {
            throw new BadSettingsException('Проверьте секретный ключ и адрес апи');
        }

        if ($request->checkRequiredFields() === false) {
            throw new Requests\Exceptions\RequiredFieldsNullException('Не все обязательные параметры заполнены');
        }

        $serializer = new Serializer();
        $this->disableDebugMode();

        if (property_exists($request, 'method') && $request->method === 'POST') {
            $headers = array(
                'Content-Type: application/json',
                'Accept: application/json'
            );

            $credentials = array(
                'token' => $this->api_token,
                'method' => $request->getClassName()
            );

            if ($request->getClassName() === 'ParselCreate') {
                $sdata = array(
                    'sdata' => $serializer->toArray($request)
                );
                $data = array_merge($credentials, $sdata);
            }

            if ($request->getClassName() === 'DeliveryCalculation'){
                $data = array_merge($credentials, $serializer->toArray($request));
            }

            if ($request->getClassName() === 'DadataSuggestions'){
                $data = $serializer->toArray($request);
                $headers = $this->getDadataHeaders();
                $this->api_url = $this->dadataApiUrl;
            }

            $answer = HTTP::post($this->api_url, $data, $headers)->getAnswer();
        } else {
            $data = array(
                'method' => $request->getClassName(),
                'token'  => $this->api_token
            );
            $data = array_merge($data, $serializer->toArray($request));
            $answer = HTTP::get($this->api_url, $data)->getAnswer();
        }

        unset($serializer);
        $answerClass = $request->getResultClass();
        $type = $this->getType($answerClass);

        if ($type === false) {
            throw new UnknownTypeException('Неизвестная ошибка');
        }

        if ($type == 'class') {
            return new $answerClass($answer);
        } elseif ($type == 'bool') {
            return $answer['text'] == 'ok';
        } else {
            throw new UnknownTypeException('Неизвестная ошибка');
        }
    }

    /**
     * Проверяет принадлежит ли возвращаемый тип классу или типу bool, иначе возвращает false
     * @param $type
     * @return bool|string
     */
    protected function getType($type): bool|string
    {
        if (class_exists($type)) {
            return 'class';
        } elseif ($type == 'bool') {
            return 'bool';
        }
        return false;
    }
}
