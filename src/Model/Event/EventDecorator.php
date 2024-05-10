<?php

namespace App\Model\Event;

class EventDecorator extends Event
{
    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

}
