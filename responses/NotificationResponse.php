<?php

namespace georgique\yii2\jsonrpc\responses;

use georgique\yii2\jsonrpc\JsonRpcRequest;

/**
 * Class NotificationResponse
 *
 * This is part of a jsonrpc reponse which transports a jsonrpc notification back to the client.
 * The notification might have been created as part of the procedure execution on the server,
 * alternatively, it might have come from a different source (like in a chat server). The notification
 * does not have an id member and will not be replied to by the client.
 *
 * @property string $method
 * @property array $params
 * @package georgique\yii2\jsonrpc\responses
 */
class NotificationResponse extends JsonRpcResponse
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var array
     */
    public $params;

    /**
     * NotificationResponse constructor.
     * @param string $method
     * @param array $params
     */
    public function __construct($method, $params)
    {
        return parent::__construct([
          'method' => $method,
          'params' => $params
        ]);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
          'jsonrpc' => $this->jsonrpc,
          'method'  => $this->method,
          'params'  => $this->params
        ];
    }
}
