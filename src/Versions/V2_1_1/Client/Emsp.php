<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Locations;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens;
use Chargemap\OCPI\Versions\V2_1_1\Client\Versions;

class Emsp extends AbstractFeatures
{
    private Credentials $credentials;
    private Commands $commands;
    private Locations $locations;
    private Tokens $tokens;
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

    public function tokens(): Tokens
    {
        if(!isset($this->tokens)) {
            $this->tokens = new Tokens($this->ocpiConfiguration);
        }

        return $this->tokens;
    }

    public function versions(): Versions
    {
        if(!isset($this->versions)) {
            $this->versions = new Versions($this->ocpiConfiguration);
        }

        return $this->versions;
    }
}
