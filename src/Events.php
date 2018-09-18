<?php

namespace Netsnatch\Yii2Events;

use Yii;
use yii\base\Component;
use yii\base\Event;
use yii\base\InvalidCallException;

class Events extends Component
{
    public $events = [];

    public function init()
    {
        if (!is_array($this->events)) {
            return;
        }

        foreach ($this->events as $eventName => $eventHandler) {
            Yii::$app->on($eventName, function (Event $event) use ($eventHandler) {
                if (is_callable($eventHandler)) {
                    Yii::$container->invoke($eventHandler, [$event]);
                }

                $eventHandler = Yii::createObject($eventHandler);
                if (method_exists($eventHandler, 'handle')) {
                    return $eventHandler->handle($event);
                }

                throw new InvalidCallException(
                    'Event handler should be callable or valid class with "handle()" method'
                );
            });
        }
    }
}
