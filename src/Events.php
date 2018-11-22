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

        foreach ($this->events as $eventName => $eventHandlers) {
            if (!is_array($eventHandlers) || !isset($eventHandlers[0])) { // hash format: component, callable, string
                $eventHandlers = [$eventHandlers];
            } // else format: handler, handler 1, handler 2, ...

            foreach ($eventHandlers as $handler) {
                Yii::$app->on($eventName, function (Event $event) use ($handler) {
                    /** @var string|array|callable $handler */
                    if (is_callable($handler)) {
                        Yii::$container->invoke($handler, [$event]);
                        return true;
                    }

                    $handler = Yii::createObject($handler);
                    if (method_exists($handler, 'handle')) {
                        $handler->handle($event);
                        return true;
                    }

                    throw new InvalidCallException(
                        'Event handler should be callable or valid class with "handle()" method'
                    );
                });
            }
        }
    }
}
