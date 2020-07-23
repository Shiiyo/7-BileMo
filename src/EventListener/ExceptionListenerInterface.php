<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

interface ExceptionListenerInterface
{
    public function onKernelException(ExceptionEvent $event);
}

