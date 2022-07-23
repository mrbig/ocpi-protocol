<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Reciever\Tokens as TokensReceiver;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens as TokensSender;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands;

class V2_2_1 extends AbstractFeatures
{
    private Credentials $credentials;

    private Locations $locations;

    private TokensReceiver $tokensReceiver;

    private TokensSender $tokensSender;

    private Cdrs $cdrs;

    private Versions $versions;

    public function credentials(): Credentials
    {
        if (!isset($this->credentials)) {
            $this->credentials = new Credentials($this->ocpiConfiguration);
        }

        return $this->credentials;
    }

    public function locations(): Locations
    {
        if (!isset($this->locations)) {
            $this->locations = new Locations($this->ocpiConfiguration);
        }

        return $this->locations;
    }

    public function tokensReceiver(): TokensReceiver
    {
        if (!isset($this->tokensReceiver)) {
            $this->tokensReceiver = new TokensReceiver($this->ocpiConfiguration);
        }

        return $this->tokensReceiver;
    }

    public function tokensSender(): TokensSender
    {
        if (!isset($this->tokensSender)) {
            $this->tokensSender = new TokensSender($this->ocpiConfiguration);
        }

        return $this->tokensSender;
    }

    public function cdrs(): Cdrs
    {
        if (!isset($this->cdrs)) {
            $this->cdrs = new Cdrs($this->ocpiConfiguration);
        }

        return $this->cdrs;
    }

    public function versions(): Versions
    {
        if(!isset($this->versions)) {
            $this->versions = new Versions($this->ocpiConfiguration);
        }

        return $this->versions;
    }

    public function commandsSender(): Commands
    {
        if (!isset($this->commandsSender)) {
            $this->commandsSender = new Commands($this->ocpiConfiguration);
        }

        return $this->commandsSender;
    }
}
