<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Common\Utils\PartialModel;
use DateTime;
use JsonSerializable;

/**
 * @method bool hasCountryCode()
 * @method bool hasPartyId()
 * @method bool hasId()
 * @method bool hasStartDateTime()
 * @method bool hasEndDateTime()
 * @method bool hasKwh()
 * @method bool hasCdrToken()
 * @method bool hasAuthMethod()
 * @method bool hasAuthorizationReference()
 * @method bool hasLocationId()
 * @method bool hasEvseUid()
 * @method bool hasConnectorId()
 * @method bool hasMeterId()
 * @method bool hasCurrency()
 * @method bool hasChargingPeriods()
 * @method bool hasTotalCost()
 * @method bool hasStatus()
 * @method bool hasLastUpdated()
 * @method self withCountryCode(?string $countryCode)
 * @method self withPartyId(?string $partyId)
 * @method self withId(?string $id)
 * @method self withStartDateTime(?DateTime $startDateTime)
 * @method self withEndDateTime(?DateTime $endDateTime)
 * @method self withKwh(?float $kwh)
 * @method self withCdrToken(?CdrToken $cdrToken)
 * @method self withAuthMethod(?AuthMethod $authMethod)
 * @method self withAuthorizationReference(?string $authorizationReference)
 * @method self withLocationId(?string $locationId)
 * @method self withEvseUid(?string $evseUid)
 * @method self withConnectorId(?string $connectorId)
 * @method self withMeterId(?string $meterId)
 * @method self withCurrency(?string $currency)
 * @method self withChargingPeriods()
 * @method self withTotalCost(?Price $totalCost)
 * @method self withStatus(?SessionStatus $status)
 * @method self withLastUpdated(?DateTime $lastUpdated)
 */
class PartialSession extends PartialModel implements JsonSerializable
{
    private ?string $countryCode = null;
    private ?string $partyId = null;
    private ?string $id = null;
    private ?DateTime $startDateTime = null;
    private ?DateTime $endDateTime = null;
    private ?float $kwh = null;
    private ?CdrToken $cdrToken = null;
    private ?AuthMethod $authMethod = null;
    private ?string $authorizationReference= null;
    private ?string $locationId = null;
    private ?string $evseUid = null;
    private ?string $connectorId = null;
    private ?string $meterId = null;
    private ?string $currency = null;
    /** @var ChargingPeriod[]|null */
    private ?array $chargingPeriods = null;
    private ?Price $totalCost = null;
    private ?SessionStatus $status = null;
    private ?DateTime $lastUpdated = null;

    protected function _withCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    protected function _withPartyId(?string $partyId): self
    {
        $this->partyId = $partyId;
        return $this;
    }

    protected function _withId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    protected function _withStartDateTime(?DateTime $startDateTime): self
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    protected function _withEndDateTime(?DateTime $endDateTime): self
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }

    protected function _withKwh(?float $kwh): self
    {
        $this->kwh = $kwh;
        return $this;
    }

    protected function _withCdrToken(?CdrToken $cdrToken): self
    {
        $this->cdrToken = $cdrToken;
        return $this;
    }

    protected function _withAuthMethod(?AuthMethod $authMethod): self
    {
        $this->authMethod = $authMethod;
        return $this;
    }

    protected function _withAuthorizationReference(?string $authorizationReference): self
    {
        $this->authorizationReference = $authorizationReference;
        return $this;
    }

    protected function _withLocationId(?string $locationId): self
    {
        $this->locationId = $locationId;
        return $this;
    }

    protected function _withEvseUid(?string $evseUid): self
    {
        $this->evseUid = $evseUid;
        return $this;
    }

    protected function _withConnectorId(?string $connectorId): self
    {
        $this->connectorId = $connectorId;
        return $this;
    }

    protected function _withMeterId(?string $meterId): self
    {
        $this->meterId = $meterId;
        return $this;
    }

    protected function _withCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    protected function _withChargingPeriods(): self
    {
        $this->chargingPeriods = [];
        return $this;
    }

    public function withChargingPeriod(ChargingPeriod $period): self
    {
        $this->chargingPeriods[] = $period;
        return $this;
    }

    protected function _withTotalCost(?Price $totalCost): self
    {
        $this->totalCost = $totalCost;
        return $this;
    }

    protected function _withStatus(?SessionStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    protected function _withLastUpdated(?DateTime $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getPartyId(): ?string
    {
        return $this->partyId;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStartDateTime(): ?DateTime
    {
        return $this->startDateTime;
    }

    public function getEndDateTime(): ?DateTime
    {
        return $this->endDateTime;
    }

    public function getKwh(): ?float
    {
        return $this->kwh;
    }

    public function getCdrToken(): ?CdrToken
    {
        return $this->cdrToken;
    }

    public function getAuthMethod(): ?AuthMethod
    {
        return $this->authMethod;
    }

    public function getAuthorizationReference(): ?string
    {
        return $this->authorizationReference;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getEvseUid(): string
    {
        return $this->evseUid;
    }

    public function getConnectorId(): string
    {
        return $this->connectorId;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getMeterId(): ?string
    {
        return $this->meterId;
    }

    public function getChargingPeriods(): ?array
    {
        return $this->chargingPeriods;
    }

    public function getTotalCost(): ?Price
    {
        return $this->totalCost;
    }

    public function getStatus(): ?SessionStatus
    {
        return $this->status;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];

        if ($this->hasCountryCode()) {
            $return['country_code'] = $this->countryCode;
        }
        if ($this->hasPartyId()) {
            $return['party_id'] = $this->partyId;
        }
        if ($this->hasId()) {
            $return['id'] = $this->id;
        }
        if ($this->hasStartDateTime()) {
            $return['start_date_time'] = DateTimeFormatter::format($this->startDateTime);
        }
        if ($this->hasKwh()) {
            $return['kwh'] = $this->kwh;
        }
        if ($this->hasCdrToken()) {
            $return['cdr_token'] = $this->cdrToken;
        }
        if ($this->hasAuthMethod()) {
            $return['auth_method'] = $this->authMethod;
        }
        if ($this->hasAuthorizationReference()) {
            $return['authorization_reference'] = $this->authorizationReference;
        }
        if ($this->hasLocationId()) {
            $return['location_id'] = $this->locationId;
        }
        if ($this->hasEvseUid()) {
            $return['evse_uid'] = $this->evseUid;
        }
        if ($this->hasConnectorId()) {
            $return['connector_id'] = $this->connectorId;
        }
        if ($this->hasCurrency()) {
            $return['currency'] = $this->currency;
        }
        if ($this->hasChargingPeriods()) {
            $return['charging_periods'] = $this->chargingPeriods;
        }
        if ($this->hasStatus()) {
            $return['status'] = $this->status;
        }
        if ($this->hasLastUpdated()) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        if ($this->hasMeterId()) {
            $return['meter_id'] = $this->meterId;
        }
        if ($this->hasTotalCost()) {
            $return['total_cost'] = $this->totalCost;
        }
        if ($this->hasEndDateTime()) {
            $return['end_date_time'] = DateTimeFormatter::format($this->endDateTime);
        }
        return $return;
    }
}
