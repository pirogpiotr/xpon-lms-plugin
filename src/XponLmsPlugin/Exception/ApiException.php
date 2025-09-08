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
            if (isset($response->body[XponApiHelper::KEY_ERROR_CODE])) {
                $message = sprintf("%d: %s", $response->body[XponApiHelper::KEY_ERROR_CODE], $message);
            }
            if (isset($response->body[XponApiHelper::KEY_ERROR_CLASS])) {
                $message = sprintf("(%s) %s", $response->body[XponApiHelper::KEY_ERROR_CLASS], $message);
            }
        }

        parent::__construct($message, $this->response ? $this->response->code : 0);
    }
}
