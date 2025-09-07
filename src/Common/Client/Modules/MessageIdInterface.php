<?php

namespace Chargemap\OCPI\Common\Client\Modules;
interface MessageIdInterface
{
    public function getRequestId(): string;
    public function getCorrelationId(): string;
}
