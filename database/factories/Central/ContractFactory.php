<?php

declare(strict_types=1);

namespace Database\Factories\Central;

use App\Enums\Service;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    #[Override]
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'agreement_date' => Date::now()->subDays($this->faker->numberBetween(1, 30)),
            'dealer_name' => $this->faker->company(),
            'services' => $this->faker->randomElements(array_column(Service::cases(), 'value'), $this->faker->numberBetween(1, count(Service::cases()))),
            'commence_date' => Date::now()->addDays($this->faker->numberBetween(1, 60)),
            'yearly_inspection_total' => $this->faker->numberBetween(1, 100),
            'initial_fee' => $this->faker->randomFloat(2, 100, 5000),
            'monthly_fee' => $this->faker->randomFloat(2, 50, 500),
            'armp_signature' => $this->faker->optional()->name(),
            'armp_printed_name' => $this->faker->optional()->name(),
            'armp_date_signed' => $this->faker->optional()->dateTimeBetween('-30 days', 'now'),
            'dealer_signature' => $this->faker->optional()->name(),
            'dealer_printed_name' => $this->faker->optional()->name(),
            'dealer_date_signed' => $this->faker->optional()->dateTimeBetween('-30 days', 'now'),
            'dealer_physical_address' => $this->faker->streetAddress(),
            'dealer_physical_city' => $this->faker->city(),
            'dealer_physical_state' => $this->faker->randomElement(['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY']),
            'dealer_physical_zip' => $this->faker->postcode(),
            'dealer_phone' => $this->faker->phoneNumber(),
            'dealer_qi_name' => $this->faker->name(),
            'dealer_qi_email' => $this->faker->unique()->safeEmail(),
            'dealer_billing_address' => $this->faker->streetAddress(),
            'dealer_billing_city' => $this->faker->city(),
            'dealer_billing_state' => $this->faker->randomElement(['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY']),
            'dealer_billing_zip' => $this->faker->postcode(),
            'dealer_billing_fax' => $this->faker->optional()->phoneNumber(),
            'dealer_billing_contact_name' => $this->faker->name(),
            'dealer_billing_contact_title' => $this->faker->jobTitle(),
            'dealer_billing_contact_email' => $this->faker->unique()->safeEmail(),
            'additional_locations' => [],
            'pdf_path' => $this->faker->optional()->filePath(),
            'contract_type' => $this->faker->randomElement(['yearly', 'monthly']),
            'user_id' => User::factory(),
        ];
    }
}
