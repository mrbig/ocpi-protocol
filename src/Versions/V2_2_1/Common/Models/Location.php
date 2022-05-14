<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Location implements JsonSerializable
{
    private string $countryCode;

    private string $partyId;

    private string $id;

    private bool $publish;

    /** @var PublishTokenType[] */
    private array $publishAllowedTo = [];

    private ?string $name;

    private string $address;

    private string $city;

    private ?string $postalCode;

    private ?string $state;

    private string $country;

    private GeoLocation $coordinates;

    /** @var AdditionalGeoLocation[] */
    private array $relatedLocations = [];

    private ?ParkingType $parkingType;

    /** @var EVSE[] */
    private array $evses = [];

    /** @var DisplayText[] */
    private array $directions = [];

    private ?BusinessDetails $operator;

    private ?BusinessDetails $suboperator;

    private ?BusinessDetails $owner;

    /** @var Facility[] */
    private array $facilities = [];

    private ?string $timeZone;

    private ?Hours $openingTimes;

    private ?bool $chargingWhenClosed;

    /** @var Image[] */
    private array $images = [];

    private ?EnergyMix $energyMix;

    private DateTime $lastUpdated;

    public function __construct(
        string $countryCode,
        string $partyId,
        string $id,
        bool $publish,
        ?string $name,
        string $address,
        string $city,
        ?string $postalCode,
        ?string $state,
        string $country,
        GeoLocation $coordinates,
        ?ParkingType $parkingType,
        ?BusinessDetails $operator,
        ?BusinessDetails $suboperator,
        ?BusinessDetails $owner,
        ?string $timeZone,
        ?Hours $openingTimes,
        ?bool $chargingWhenClosed,
        ?EnergyMix $energyMix,
        DateTime $lastUpdated
    )
    {
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->id = $id;
        $this->publish = $publish;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->state = $state;
        $this->country = $country;
        $this->coordinates = $coordinates;
        $this->parkingType = $parkingType;
        $this->operator = $operator;
        $this->suboperator = $suboperator;
        $this->owner = $owner;
        $this->timeZone = $timeZone;
        $this->openingTimes = $openingTimes;
        $this->chargingWhenClosed = $chargingWhenClosed;
        $this->energyMix = $energyMix;
        $this->lastUpdated = $lastUpdated;
    }
    
    public function addPublishAllowedTo(PublishTokenType $type): self
    {
        $this->publishAllowedTo[] = $type;

        return $this;
    }

    public function addRelatedLocation(AdditionalGeoLocation $relatedLocation): self
    {
        $this->relatedLocations[] = $relatedLocation;

        return $this;
    }

    public function addEVSE(EVSE $evse): self
    {
        $this->evses[] = $evse;

        return $this;
    }

    public function addDirection(DisplayText $direction): self
    {
        $this->directions[] = $direction;

        return $this;
    }

    public function addFacility(Facility $facility): self
    {
        $this->facilities[] = $facility;

        return $this;
    }

    public function addImage(Image $image): self
    {
        $this->images[] = $image;

        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPublish(): bool
    {
        return $this->publish;
    }

    /**
     * @return PublishTokenType[] 
     */
    public function getPublishAllowedTo(): array
    {
        return $this->publishAllowedTo;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCoordinates(): GeoLocation
    {
        return $this->coordinates;
    }

    /**
     * @return AdditionalGeoLocation[]
     */
    public function getRelatedLocations(): array
    {
        return $this->relatedLocations;
    }

    public function getParkingType(): ParkingType
    {
        return $this->parkingType;
    }

    /**
     * @return EVSE[]
     */
    public function getEvses(): array
    {
        return $this->evses;
    }

    /**
     * @return DisplayText[]
     */
    public function getDirections(): array
    {
        return $this->directions;
    }

    public function getOperator(): ?BusinessDetails
    {
        return $this->operator;
    }

    public function getSuboperator(): ?BusinessDetails
    {
        return $this->suboperator;
    }

    public function getOwner(): ?BusinessDetails
    {
        return $this->owner;
    }

    /**
     * @return Facility[]
     */
    public function getFacilities(): array
    {
        return $this->facilities;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function getOpeningTimes(): ?Hours
    {
        return $this->openingTimes;
    }

    public function getChargingWhenClosed(): ?bool
    {
        return $this->chargingWhenClosed;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    public function getEnergyMix(): ?EnergyMix
    {
        return $this->energyMix;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'country_code' => $this->countryCode,
            'party_id' => $this->partyId,
            'id' => $this->id,
            'publish' => $this->publish,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'coordinates' => $this->coordinates,
            'evses' => $this->evses,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated),
        ];

        if (count($this->publishAllowedTo) > 0) {
            $return['publish_allowed_to'] = $this->publishAllowedTo;
        }

        if (count($this->relatedLocations) > 0) {
            $return['related_locations'] = $this->relatedLocations;
        }

        if (count($this->directions) > 0) {
            $return['directions'] = $this->directions;
        }

        if (count($this->facilities) > 0) {
            $return['facilities'] = $this->facilities;
        }

        if (count($this->images) > 0) {
            $return['images'] = $this->images;
        }

        if ($this->name !== null) {
            $return['name'] = $this->name;
        }

        if ($this->postalCode !== null) {
            $return['postal_code'] = $this->postalCode;
        }

        if ($this->state !== null) {
            $return['state'] = $this->state;
        }

        if ($this->parkingType !== null) {
            $return['parking_type'] = $this->parkingType;
        }

        if ($this->operator !== null) {
            $return['operator'] = $this->operator;
        }

        if ($this->suboperator !== null) {
            $return['suboperator'] = $this->suboperator;
        }

        if ($this->owner !== null) {
            $return['owner'] = $this->owner;
        }

        if ($this->timeZone !== null) {
            $return['time_zone'] = $this->timeZone;
        }

        if ($this->openingTimes !== null) {
            $return['opening_times'] = $this->openingTimes;
        }

        if ($this->chargingWhenClosed !== null) {
            $return['charging_when_closed'] = $this->chargingWhenClosed;
        }

        if ($this->energyMix !== null) {
            $return['energy_mix'] = $this->energyMix;
        }

        return $return;
    }
}
