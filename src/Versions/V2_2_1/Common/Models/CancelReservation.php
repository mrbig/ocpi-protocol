<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class CancelReservation implements JsonSerializable
{

    public string $responseUrl;

    public string $reservationId;

    public function __construct(
        string $responseUrl,
        string $reservationId
    )
    {
        $this->responseUrl = $responseUrl;
        $this->reservationId = $reservationId;
    }

    /**
     * Get the value of response_url
     */ 
    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    /**
     * Get the value of reservation_id
     */ 
    public function getReservationId(): string
    {
        return $this->reservationId;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'response_url' => $this->responseUrl,
            'reservation_id' => $this->reservationId,
        ];

        return $return;
    }
}