<?php

namespace XponLmsPlugin\Exception;

use Httpful\Response;
use XponLmsPlugin\Lib\XponApiHelper;

class ApiException extends XponLmsPluginException
{
    /** @var Response */
    protected $response;

    /**
     * ApiException constructor.
     * @param Response|null $response
     * @param string $message
     */
    public function __construct($response, $message = null)
    {
        if ($response instanceof Response) {
            $this->response = $response;
        }

        if ($message === null && isset($response->body) && isset($response->body[XponApiHelper::KEY_ERROR_MESSAGE])) {
            $message = $response->body[XponApiHelper::KEY_ERROR_MESSAGE];
        }

        parent::__construct($message, $this->response ? $this->response->code : 0);
    }
}
