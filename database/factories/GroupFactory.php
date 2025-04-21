<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Person;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Person> */
class GroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id'       => Tenant::factory(),
            'some_identifier' => fake()->uuid(),
            'name'            => fake()->unique()->name(),
        ];
    }
}
