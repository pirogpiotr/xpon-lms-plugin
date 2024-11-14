<?php

namespace XponLmsPlugin\Controller\Page;

use Httpful\Exception\ConnectionErrorException;
use InvalidArgumentException;
use XponLmsPlugin\Exception\ApiException;
use XponLmsPlugin\Lib\UrlGenerator;

class ImageViewPageController extends AbstractPageController
{
    const KEY_URL = 'url';
    const KEY_INTERVAL = 'interval';
    const KEY_TRANSPARENT = 'transparent';

    /**
     * @throws ApiException
     * @throws ConnectionErrorException
     * @throws InvalidArgumentException
     */
    public function show()
    {
        $url = filter_input(INPUT_GET, self::KEY_URL);
        if (!$url) {
            throw new InvalidArgumentException("data validation error");
        }

        $params = array_diff($_GET, [UrlGenerator::KEY_MODULE, self::KEY_URL]);
        if (!isset($params[self::KEY_INTERVAL])) {
            $params[self::KEY_INTERVAL] = 60 * 60 * 24 * 7;
        }

        $params[self::KEY_TRANSPARENT] = 1;

        $apiClient = $this->getXponApiHelper()->getApiClient();
        $response = $apiClient->get($url . '?' . http_build_query($params));
        if ($response->code !== 200) {
            throw new ApiException($response);
        }
        $contentType = $response->headers['Content-Type'];

        header("Content-Type: $contentType");
        echo $response;
    }

    protected function userShow()
    {
        //not used
    }
}
