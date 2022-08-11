<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Client;

use Chargemap\OCPI\Common\Client\Modules\AbstractFeatures;
use Chargemap\OCPI\Versions\V2_2_1\Client\Reciever\Tokens;

class Receiver extends AbstractFeatures
{
    private Credentials $credentials;

    private Tokens $tokens;

    private Versions $versions;

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

    public function versions(): Versions
    {
        if(!isset($this->versions)) {
            $this->versions = new Versions($this->ocpiConfiguration);
        }

        return $this->versions;
    }
}
