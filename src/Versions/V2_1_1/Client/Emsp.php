<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Cdrs;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tariffs;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Sessions;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions;

class Emsp extends AbstractFeatures
{
    private Cdrs $cdrs;
    private Credentials $credentials;
    private Commands $commands;
    private Locations $locations;
    private Tariffs $tariffs;
    private Tokens $tokens;
    private Sessions $sessions;
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

    public function commands(): Commands
    {
        if(!isset($this->commands)) {
            $this->commands = new Commands($this->ocpiConfiguration);
        }

        return $this->commands;
    }

    public function tariffs(): Tariffs
    {
        if(!isset($this->tariffs)) {
            $this->tariffs = new Tariffs($this->ocpiConfiguration);
        }

        return $this->tariffs;
    }

    public function tokens(): Tokens
    {
        if(!isset($this->tokens)) {
            $this->tokens = new Tokens($this->ocpiConfiguration);
        }

        return $this->tokens;
    }

    public function sessions(): Sessions
    {
        if(!isset($this->sessions)) {
            $this->sessions = new Sessions($this->ocpiConfiguration);
        }

        return $this->sessions;
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
}
