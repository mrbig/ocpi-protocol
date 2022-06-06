<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Session implements JsonSerializable
{
    private string $countryCode;
    private string $partyId;
    private string $id;
    private DateTime $startDateTime;
    private ?DateTime $endDateTime;
    private float $kwh;
    private CdrToken $cdrToken;
    private AuthMethod $authMethod;
    private ?string $authorizationReference;
    private string $locationId;
    private string $evseUid;
    private string $connectorId;
    private ?string $meterId;
    private string $currency;
    /** @var ChargingPeriod[] */
    private array $chargingPeriods = [];
    private ?Price $totalCost;
    private SessionStatus $status;
    private DateTime $lastUpdated;

    public function __construct(
        string $countryCode,
        string $partyId,
        string $id,
        DateTime $startDateTime,
        ?DateTime $endDateTime,
        float $kwh,
        CdrToken $cdrToken,
        AuthMethod $authMethod,
        ?string $authorizationReference,
        string $locationId,
        string $evseUid,
        string $connectorId,
        ?string $meterId,
        string $currency,
        ?Price $totalCost,
        SessionStatus $status,
        DateTime $lastUpdated
    ) {
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->id = $id;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->kwh = $kwh;
        $this->cdrToken = $cdrToken;
        $this->authMethod = $authMethod;
        $this->authorizationReference = $authorizationReference;
        $this->locationId = $locationId;
        $this->evseUid = $evseUid;
        $this->connectorId = $connectorId;
        $this->meterId = $meterId;
        $this->currency = $currency;
        $this->totalCost = $totalCost;
        $this->status = $status;
        $this->lastUpdated = $lastUpdated;
    }

    public function addChargingPeriod(ChargingPeriod $period): void
    {
        $this->chargingPeriods[] = $period;
    }

    public function getCountryCode(): string {
        return $this->countryCode;
    }

    public function getPartyId(): string {
        return $this->partyId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStartDateTime(): DateTime
    {
        return $this->startDateTime;
    }

    public function getEndDateTime(): ?DateTime
    {
        return $this->endDateTime;
    }

    public function getKwh(): float
    {
        return $this->kwh;
    }

    public function getCdrToken(): CdrToken
    {
        return $this->cdrToken;
    }

    public function getAuthMethod(): AuthMethod
    {
        return $this->authMethod;
    }

    public function getAuthorizationReference(): ?string
    {
        return $this->authorizationReference;
    }

    public function getLocationId(): string
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

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getMeterId(): ?string
    {
        return $this->meterId;
    }

    public function getChargingPeriods(): array
    {
        return $this->chargingPeriods;
    }

    public function getTotalCost(): ?Price
    {
        return $this->totalCost;
    }

    public function getStatus(): SessionStatus
    {
        return $this->status;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function merge(PartialSession $partialSession): self
    {
        $new = new Session(
            $partialSession->hasCountryCode() ? $partialSession->getCountryCode() : $this->countryCode,
            $partialSession->hasPartyId() ? $partialSession->getPartyId() : $this->partyId,
            $partialSession->hasId() ? $partialSession->getId() : $this->id,
            $partialSession->hasStartDateTime() ? $partialSession->getStartDateTime() : $this->startDateTime,
            $partialSession->hasEndDateTime() ? $partialSession->getEndDateTime() : $this->endDateTime,
            $partialSession->hasKwh() ? $partialSession->getKwh() : $this->kwh,
            $partialSession->hasCdrToken() ? $partialSession->getCdrToken() : $this->cdrToken,
            $partialSession->hasAuthMethod() ? $partialSession->getAuthMethod() : $this->authMethod,
            $partialSession->hasAuthorizationReference() ? $partialSession->getAuthorizationReference() : $this->authorizationReference,
            $partialSession->hasLocationId() ? $partialSession->getLocationId() : $this->locationId,
            $partialSession->hasEvseUid() ? $partialSession->getEvseUid() : $this->evseUid,
            $partialSession->hasConnectorId() ? $partialSession->getConnectorId() : $this->connectorId,
            $partialSession->hasMeterId() ? $partialSession->getMeterId() : $this->meterId,
            $partialSession->hasCurrency() ? $partialSession->getCurrency() : $this->currency,
            $partialSession->hasTotalCost() ? $partialSession->getTotalCost() : $this->totalCost,
            $partialSession->hasStatus() ? $partialSession->getStatus() : $this->status,
            $partialSession->hasLastUpdated() ? $partialSession->getLastUpdated() : $this->lastUpdated
        );
        $chargingPeriods = $partialSession->hasChargingPeriods() ? $partialSession->getChargingPeriods() : $this->chargingPeriods;
        foreach ($chargingPeriods as $chargingPeriod) {
            $new->addChargingPeriod($chargingPeriod);
        }
        return $new;
    }

    public function diff(Session $other): ?PartialSession
    {
        $diff = null;
        if ($this->countryCode !== $other->countryCode) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withCountryCode($other->countryCode);
        }
        if ($this->partyId !== $other->partyId) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withPartyId($other->partyId);
        }
        if ($this->id !== $other->id) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withId($other->id);
        }
        if ($this->startDateTime->getTimestamp() !== $other->startDateTime->getTimestamp()) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withStartDateTime($other->startDateTime);
        }
        if ($this->endDateTime === null && $other->endDateTime !== null) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withEndDateTime($other->endDateTime);
        }
        if ($this->endDateTime !== null && $other->endDateTime === null) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withEndDateTime($other->endDateTime);
        }
        if (
            $this->endDateTime !== null && $other->endDateTime !== null &&
            $this->endDateTime->getTimestamp() !== $other->endDateTime->getTimestamp()
        ) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withEndDateTime($other->endDateTime);
        }
        if ($this->kwh !== $other->kwh) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withKwh($other->kwh);
        }
        if ($this->cdrToken !== $other->cdrToken) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withCdrToken($other->cdrToken);
        }
        if (!$this->authMethod->equals($other->authMethod)) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withAuthMethod($other->authMethod);
        }
        if ($this->authorizationReference !== $other->authorizationReference) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withAuthorizationReference($other->authorizationReference);
        }
        if ($this->locationId != $other->locationId) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withLocationId($other->locationId);
        }
        if ($this->evseUid !== $other->evseUid) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withEvseUid($other->evseUid);
        }
        if ($this->connectorId !== $other->connectorId) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withConnectorId($other->connectorId);
        }
        if ($this->meterId !== $other->meterId) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withMeterId($other->meterId);
        }
        if ($this->currency !== $other->currency) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withCurrency($other->currency);
        }
        if ($this->totalCost !== $other->totalCost) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withTotalCost($other->totalCost);
        }
        if (!$this->status->equals($other->status)) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withStatus($other->status);
        }
        if ($this->lastUpdated->getTimestamp() !== $other->lastUpdated->getTimestamp()) {
            $diff = $diff ?? new PartialSession();
            $diff = $diff->withLastUpdated($other->lastUpdated);
        }
        $chargingPeriodsDiff = self::chargingPeriodsDiff($this, $other);
        if ($chargingPeriodsDiff !== null) {
            $diff = $diff ?? new PartialSession();
            //There is a difference between to, so anyway we need to init charging periods array
            $diff = $diff->withChargingPeriods();
            foreach ($chargingPeriodsDiff as $chargingPeriod) {
                $diff = $diff->withChargingPeriod($chargingPeriod);
            }
        }

        return $diff;
    }

    /**
     * Null means no difference
     * Empty array means all charging periods was deleted
     * @return \Chargemap\OCPI\Versions\V2_2_1\Common\Models\ChargingPeriod[]|null
     */
    public static function chargingPeriodsDiff(Session $first, Session $second): ?array
    {
        if (count($first->chargingPeriods) === 0 && count($second->chargingPeriods) === 0) {
            return null;
        }
        if (count($second->chargingPeriods) === 0) {
            return [];
        }
        $diff = null;
        /** @var array<int, ChargingPeriod> $chargingPeriods */
        $chargingPeriods = [];
        foreach ($first->chargingPeriods as $chargingPeriod) {
            $chargingPeriods[$chargingPeriod->getStartDate()->getTimestamp()] = $chargingPeriod;
        }
        /** @var array<int, ChargingPeriod> $chargingPeriods */
        $otherChargingPeriods = [];
        foreach ($second->chargingPeriods as $chargingPeriod) {
            $otherChargingPeriods[$chargingPeriod->getStartDate()->getTimestamp()] = $chargingPeriod;
        }
        /** @var int $timestamp */
        foreach ($otherChargingPeriods as $timestamp => $otherPeriod) {
            if (!array_key_exists($timestamp, $chargingPeriods)) {
                if ($diff === null) {
                    $diff = [];
                }
                $diff[] = $otherPeriod;
            } elseif ($chargingPeriods[$timestamp]->getCdrDimensions() != $otherPeriod->getCdrDimensions()) {
                if ($diff === null) {
                    $diff = [];
                }
                $diff[] = $otherPeriod;
            }
        }

        return $diff;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'country_code' => $this->countryCode,
            'party_id' => $this->partyId,
            'id' => $this->id,
            'start_date_time' => DateTimeFormatter::format($this->startDateTime),
            'kwh' => $this->kwh,
            'cdr_token' => $this->cdrToken,
            'auth_method' => $this->authMethod,
            'authorization_reference' => $this->authorizationReference,
            'location_id' => $this->locationId,
            'evse_uid' => $this->evseUid,
            'connector_id' => $this->connectorId,
            'currency' => $this->currency,
            'charging_periods' => $this->chargingPeriods,
            'status' => $this->status,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated)
        ];

        if ($this->meterId !== null) {
            $return['meter_id'] = $this->meterId;
        }

        if ($this->totalCost !== null) {
            $return['total_cost'] = $this->totalCost;
        }

        if ($this->endDateTime !== null) {
            $return['end_date_time'] = DateTimeFormatter::format($this->endDateTime);
        }

        return $return;
    }
}
