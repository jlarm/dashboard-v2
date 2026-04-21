<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Data;

final readonly class AdditionalLocationData
{
    public function __construct(
        public string $name,
        public string $address,
        public string $city,
        public string $state,
        public string $zip,
        public ?string $contact_name = null,
        public ?string $contact_title = null,
        public ?string $contact_email = null,
    ) {}

    /**
     * @param  array<string, mixed>  $row
     */
    public static function fromArray(array $row): self
    {
        return new self(
            name: (string) ($row['name'] ?? ''),
            address: (string) ($row['address'] ?? ''),
            city: (string) ($row['city'] ?? ''),
            state: (string) ($row['state'] ?? ''),
            zip: (string) ($row['zip'] ?? ''),
            contact_name: $row['contact_name'] !== null && $row['contact_name'] !== '' ? (string) $row['contact_name'] : null,
            contact_title: $row['contact_title'] !== null && $row['contact_title'] !== '' ? (string) $row['contact_title'] : null,
            contact_email: $row['contact_email'] !== null && $row['contact_email'] !== '' ? (string) $row['contact_email'] : null,
        );
    }

    /**
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'contact_name' => $this->contact_name,
            'contact_title' => $this->contact_title,
            'contact_email' => $this->contact_email,
        ];
    }
}
