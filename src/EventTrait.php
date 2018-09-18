<?php

namespace Netsnatch\Yii2Events;

trait EventTrait
{
    public function fire(): void
    {
        \Yii::$app->trigger(static::class, $this);
    }
}
