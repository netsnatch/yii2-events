Instalation
---
Either run

`$ php composer.phar require netsnatch/yii2-events:"~1.0.2"`

or add

`"netsnatch/yii2-events": "~1.0.2"`

to the require section of your composer.json file.


Usage
---

 - Add the following in the components section of your configuration file:
```
    'components' => [
        'events' => [
            'class' => \Netsnatch\Yii2Events\Events::class,
            'events' => [
                'app\events\SomeEvent' => 'app\events\handlers\SomeHandler',
                'app\events\SomeEvent2' => [
                    'app\events\handlers\SomeHandler2',
                    'app\events\handlers\SomeHandler3',
                ],
            ],
        ],
        // ...
    ]
```
 - Add `'events'` to bootstrap section of your configuration file 
 
 - Create event 

```
<?php

use Netsnatch\Yii2Events\EventTrait;
use yii\base\Event;

class SomeEvent extends Event
{
    use EventTrait;

    public $someParam;
}
```

 - Trigger it in controller, model, etc
 ```
 (new app\events\SomeEvent(['someParam' => 'val']))->fire();
```

 - Handle 
```
class SomeHandler
{
    public funnction handle(\app\events\SomeEvent $event)
    {
        // *** your code ***
    }
}
```
