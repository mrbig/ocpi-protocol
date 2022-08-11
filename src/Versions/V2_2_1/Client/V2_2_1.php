<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;

class V2_2_1 extends AbstractFeatures
{
    private Receiver $receiver;

    private Sender $sender;

    public function sender(): Sender
    {
        if (!isset($this->sender)) {
            $this->sender = new Sender($this->ocpiConfiguration);
        }

        return $this->sender;
    }

    public function receiver(): Receiver
    {
        if (!isset($this->sender)) {
            $this->sender = new Receiver($this->ocpiConfiguration);
        }

        return $this->sender;
    }
}
