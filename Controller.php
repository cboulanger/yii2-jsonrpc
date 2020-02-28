<?php

namespace georgique\yii2\jsonrpc;

use georgique\yii2\jsonrpc\responses\NotificationResponse;
use yii\base\InvalidArgumentException;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use Yii;

/**
 * Class Controller
 * @package georgique\yii2\jsonrpc
 */
class Controller extends \yii\web\Controller
{
    // Pass params as function arguments
    const JSON_RPC_PARAMS_PASS_FUNCARGS = 1;

    // Pass params as request body
    const JSON_RPC_PARAMS_PASS_BODY = 2;

    /**
     * @var int $paramsPassMethod Defines method to pass params to the target action.
     */
    public $paramsPassMethod = self::JSON_RPC_PARAMS_PASS_FUNCARGS;

    /**
     * @var array Whether JSON parse should parse objects in `params` as associative arrays or objects
     */
    public $requestParseAsArray = true;

    /**
     * @var array Notifications to be sent back to the server (see https://www.jsonrpc.org/specification)
     */
    protected static $notifications = [];

    public function actions()
    {
        return [
            'index' => [
                'class' => Action::class,
                'paramsPassMethod' => $this->paramsPassMethod,
                'requestParseAsArray' => $this->requestParseAsArray
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    '*' => Response::FORMAT_JSON,
                ],
            ]
        ];
    }

    /**
     * Returns the current list of notifications
     * @return array
     */
    public static function getNotifications() {
      return static::$notifications;
    }

    /**
     * Add a notification to be sent back to the client as part of the jsonrpc response
     * @param string $method
     * @param array|null $params
     */
    public static function addNotification($method, $params=null) {
      if (!$method or !is_string($method)) {
          throw new InvalidArgumentException("First argument must be a non-empty string");
      }
      if ($params and !is_array($params)) {
          throw new InvalidArgumentException("Second argument must be an array of rpc parameters");
      }
      array_push(static::$notifications, new NotificationResponse($method, $params));
    }
}
