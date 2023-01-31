<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Cdrs;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Commands;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Locations;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Sessions;
use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens;

class Sender extends AbstractFeatures
{

    private Commands $commands;

    private Credentials $credentials;

    private Locations $locations;

    private Tokens $tokens;

    private Cdrs $cdrs;

    private Versions $versions;
    
    private Sessions $sessions;

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

    public function tokens(): Tokens
    {
        if (!isset($this->tokens)) {
            $this->tokens = new Tokens($this->ocpiConfiguration);
        }

        return $this->tokens;
    }

    public function cdrs(): Cdrs
    {
        if (!isset($this->cdrs)) {
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

    public function versions(): Versions
    {
        if(!isset($this->versions)) {
            $this->versions = new Versions($this->ocpiConfiguration);
        }

        return $this->versions;
    }

    public function sessions(): Sessions
    {
        if(!isset($this->sessions)) {
            $this->sessions = new Sessions($this->ocpiConfiguration);
        }

        return $this->sessions;
    }
}
