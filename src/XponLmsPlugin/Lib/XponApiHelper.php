<?php

namespace XponLmsPlugin\Lib;

use Httpful\Exception\ConnectionErrorException;
use Httpful\Http;
use Httpful\Response;
use XponLmsPlugin\Exception\ApiException;

class XponApiHelper
{
    const KEY_SORT = 'sort';
    const KEY_LIMIT = 'limit';
    const KEY_OFFSET = 'offset';
    const KEY_SEARCH = 'search';

    const KEY_MESSAGE = 'message';

    const KEY_ERROR_MESSAGE = 'message';
    const KEY_ERROR_CLASS = 'class';
    const KEY_ERROR_OLTID = 'oltid';

    /** @var string Liczba elementów po filtrowaniu. */
    const HEADER_TOTAL_COUNT = 'X-Total-Count';

    // const HEADER_UNFILETERED_COUNT = 'X-Unfiltered-Count';
    const KEY_SOURCE = 'source';
    const SOURCE_SNMP = 'snmp';
    const SOURCE_CACHE = 'cache';

    // autofind
    const KEY_RESPONSE_AUTOFIND = 'autofind';
    const KEY_RESPONSE_SUCCESS = 'success';
    const KEY_RESPONSE_ERRORS = 'errors';

    const KEY_ONTDELETE_RELATED = 'related';
    const KEY_ONTDELETE_CUSTOMER = 'customer';

    const KEY_ONTSETUP_SETUP = 'setup';
    const ONTSETUP_ALL = 'all';
    const ONTSETUP_ONT = 'ont';
    const ONTSETUP_OLT = 'olt';

    /** @var ApiClient */
    protected $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->setApiClient($apiClient);
    }

    /**
     * @return ApiClient
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * @param ApiClient $apiClient
     * @return static
     */
    public function setApiClient(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * @param $response
     * @throws ApiException
     */
    public static function verifyReponseAndThrowExceptions($response)
    {
        if ($response->code < ApiClient::HTTP_STATUS_OK || $response->code > 300) {
            throw new ApiException($response);
        }
    }

    /**
     * @param $method
     * @param $url
     * @param mixed ...$args
     * @return Response
     * @throws ApiException
     */
    public function requestWrapper($method, $url, ...$args)
    {
        try {
            $response = $this->getApiClient()->sendRequest($method, $url, ...$args);
        } catch (ConnectionErrorException $e) {
            throw new ApiException(null, "connection error: {$e->getMessage()} ({$e->getCode()})");
        }

        static::verifyReponseAndThrowExceptions($response);

        return $response;
    }

    /**
     * @param string $url
     * @param array $queryParams
     * @param Pager|null $pager
     * @return array
     * @throws ApiException
     */
    public function get($url, array $queryParams = [], Pager $pager = null)
    {
        if ($pager) {
            if ($sort = $pager->getSort(true)) {
                $queryParams[static::KEY_SORT] = $sort;
            }

            $queryParams[static::KEY_LIMIT] = $pager->getLimit();
            $queryParams[static::KEY_OFFSET] = $pager->getOffset();
        }

        if ($queryParams) {
            $url .= '?' . http_build_query($queryParams);
        }

        $response = $this->requestWrapper(Http::GET, $url);

        if ($pager) {
            if (isset($response->headers[self::HEADER_TOTAL_COUNT])) {
                $pager->setTotal(intval($response->headers[self::HEADER_TOTAL_COUNT]));
            } else {
                $pager->setTotal(count($response->body));
            }
        }

        return $response->body;
    }

    /**
     * @param string $url
     * @param array $data
     * @return array
     * @throws ApiException
     */
    public function delete($url, array $data = [])
    {
        return $this->requestWrapper(Http::DELETE, $url, $data)->body;
    }

    /**
     * @param $url
     * @param array $data
     * @return array|object|string
     * @throws ApiException
     */
    public function post($url, array $data = [])
    {
        return $this->requestWrapper(Http::POST, $url, $data)->body;
    }

    /**
     * @param $url
     * @param array $data
     * @return array|object|string
     * @throws ApiException
     */
    public function patch($url, array $data)
    {
        return $this->requestWrapper(Http::PATCH, $url, $data)->body;
    }

    /**
     * @return array
     * @throws ApiException
     */
    public function getOltList()
    {
        return $this->get('olts');
    }

    /**
     * @param int $oltId
     * @return array
     * @throws ApiException
     */
    public function getGponSlotList($oltId)
    {
        return $this->get("olts/$oltId/slots?typename=*GP*");
    }

    /**
     * @param int $oltId
     * @param int|null $slotId
     * @return array
     * @throws ApiException
     */
    public function getGponPortList($oltId, $slotId = null)
    {
        $url = "olts/$oltId/ports/gpon";

        if ($slotId !== null) {
            $url .= "/0/$slotId";
        }

        return $this->get($url);
    }

    /**
     * @return array
     * @throws ApiException
     */
    public function getOntSetupProfiles()
    {
        return $this->get('xpon/ontsetupprofiles');
    }

    /**
     * @param string|null $equipId
     * @return array
     * @throws ApiException
     */
    public function getConfiguredOntAttributes($equipId = null)
    {
        $url = 'xpon/ontattributes';

        if ($equipId) {
            $url .= "/$equipId";
        }

        return $this->get($url);
    }

}
