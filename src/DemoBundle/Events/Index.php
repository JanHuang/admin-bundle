<?php

namespace DemoBundle\Events;

use FastD\Framework\Events\TemplateEvent;

class Index extends TemplateEvent
{
    public function indexAction()
    {
        return $this->render('login.twig');
    }

    public function welcomeAction()
    {
        return 'hello world';
    }
}