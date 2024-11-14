<?php

namespace XponLmsPlugin\Lib;

use Httpful\Exception\ConnectionErrorException;
use Httpful\Handlers\JsonHandler;
use Httpful\Http;
use Httpful\Httpful;
use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;

class ApiClient
{
    const KEY_BASEURL = 'url';
    const KEY_LOGIN = 'login';
    const KEY_PASSWORD = 'password';

    const HTTP_STATUS_OK = 200;

    protected $baseUrl;
    protected $login;
    protected $password;

    public function __construct(array $apiData)
    {
        $this->baseUrl = array_key_exists(self::KEY_BASEURL, $apiData) ? $apiData[self::KEY_BASEURL] : null;
        $this->login = array_key_exists(self::KEY_LOGIN, $apiData) ? $apiData[self::KEY_LOGIN] : null;
        $this->password = array_key_exists(self::KEY_PASSWORD, $apiData) ? $apiData[self::KEY_PASSWORD] : null;

        Httpful::register(Mime::JSON, new JsonHandler(['decode_as_array' => true]));
    }

    /**
     * @param string $method
     * @param string $relativeUrl
     * @param array $data
     * @return Response
     * @throws ConnectionErrorException
     */
    public function sendRequest($method, $relativeUrl, array $data = [])
    {
        $url = sprintf("%s/%s", $this->baseUrl, $relativeUrl);

        $request = Request::init($method)->uri($url);

        if ($data) {
            $request->body($data, Mime::JSON);
        }

        $response = $request->authenticateWith($this->login, $this->password)->send();

        unset($response->request->username);
        unset($response->request->password);

        return $response;
    }

    /**
     * @param string $url
     * @return Response
     * @throws ConnectionErrorException
     */
    public function get($url)
    {
        return $this->sendRequest(Http::GET, $url);
    }

    /**
     * @param $url
     * @param array $data
     * @return Response
     * @throws ConnectionErrorException
     */
    public function delete($url, array $data)
    {
        return $this->sendRequest(Http::DELETE, $url, $data);
    }
}
