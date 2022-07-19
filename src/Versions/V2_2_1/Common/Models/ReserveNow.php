<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;

class ReserveNow extends Command
{
    private string $responseUrl;
    private Token $token;
    private DateTime $expiryDate;
    private string $reservationId;
    private string $locationId;
    private ?string $evseUid;
    private ?string $authorizationReference;

    public function __construct(
        string $responseUrl,
        Token $token,
        DateTime $expiryDate,
        string $reservationId,
        string $locationId,
        ?string $evseUid,
        ?string $authorizationReference
    )
    {
        $this->responseUrl = $responseUrl;
        $this->token = $token;
        $this->expiryDate = $expiryDate;
        $this->reservationId = $reservationId;
        $this->locationId = $locationId;
        $this->evseUid = $evseUid;
        $this->authorizationReference = $authorizationReference;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'response_url' => $this->responseUrl,
            'token' => $this->token,
            'expiry_date' => DateTimeFormatter::format($this->expiryDate),
            'reservation_id' => $this->reservationId,
            'location_id' => $this->locationId,
        ];

        if ($this->evseUid) {
            $return['evse_uid'] = $this->evseUid;
        }

        if ($this->authorizationReference) {
            $return['authorization_reference'] = $this->authorizationReference;
        }


        return $return;
    }

    /**
     * Get the value of responseUrl
     */ 
    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    /**
     * Get the value of token
     */ 
    public function getToken(): Token
    {
        return $this->token;
    }

    /**
     * Get the value of expiryDate
     */ 
    public function getExpiryDate(): DateTime
    {
        return $this->expiryDate;
    }

    /**
     * Get the value of reservationId
     */ 
    public function getReservationId(): string
    {
        return $this->reservationId;
    }

    /**
     * Get the value of locationId
     */ 
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Get the value of evseUid
     */ 
    public function getEvseUid(): ?string
    {
        return $this->evseUid;
    }

    /**
     * Get the value of authorizationReference
     */ 
    public function getAuthorizationReference(): ?string
    {
        return $this->authorizationReference;
    }
}