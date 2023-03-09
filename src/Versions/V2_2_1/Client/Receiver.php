<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Cdrs;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Tokens;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Sessions;
use Chargemap\OCPI\Versions\V2_2_1\Client\Receiver\Commands;

class Receiver extends AbstractFeatures
{
    private Credentials $credentials;

    private Sessions $sessions;

    private Tokens $tokens;

    private Versions $versions;

    private Cdrs $cdrs;

    private Commands $commands;

    public function credentials(): Credentials
    {
        if (!isset($this->credentials)) {
            $this->credentials = new Credentials($this->ocpiConfiguration);
        }

        return $this->credentials;
    }

    public function tokens(): Tokens
    {
        if (!isset($this->tokens)) {
            $this->tokens = new Tokens($this->ocpiConfiguration);
        }

        return $this->tokens;
    }

    public function sessions(): Sessions
    {
        if (!isset($this->sessions)) {
            $this->sessions = new Sessions($this->ocpiConfiguration);
        }

        return $this->sessions;
    }

    public function versions(): Versions
    {
        if(!isset($this->versions)) {
            $this->versions = new Versions($this->ocpiConfiguration);
        }

        return $this->versions;
    }

    public function cdrs(): Cdrs
    {
        if(!isset($this->cdrs)) {
            $this->cdrs = new Cdrs($this->ocpiConfiguration);
        }

        return $this->cdrs;
    }

    public function commands(): Commands
    {
        if (!isset($this->commands)) {
            $this->commands = new Commands($this->ocpiConfiguration);
        }

        return $this->commands;
    }
}
