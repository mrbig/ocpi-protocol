<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class SignedData implements JsonSerializable
{
    private string $encodingMethod;

    private int $encodingMethodVersion;

    private string $publicKey;

    /** @var SignedValue[] */
    private array $signedValues = [];

    private ?string $url;

    public function __construct(
        string $encodingMethod,
        int $encodingMethodVersion,
        string $publicKey,
        ?string $url
    )
    {
        $this->encodingMethod = $encodingMethod;
        $this->encodingMethodVersion = $encodingMethodVersion;
        $this->publicKey = $publicKey;
        $this->url = $url;
    }

    public function addSignedValue(SignedValue $value): self
    {
        $this->signedValues[] = $value;

        return $this;
    }

    public function getEncodingMethod(): string {
        return $this->encodingMethod;
    }

    public function getEncodingMethodVersion(): int {
        return $this->encodingMethodVersion;
    }

    public function getPublicKey(): string {
        return $this->publicKey;
    }

    public function getSignedValues(): array {
        return $this->signedValues;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'encoding_method' => $this->encodingMethod,
            'encoding_method_version' => $this->encodingMethodVersion,
            'public_key' => $this->publicKey,
            'url' => $this->url
        ];

        if (count($this->signedValues) > 0) {
            $return['signed_values'] = $this->signedValues;
        }

        return $return;
    }
}
