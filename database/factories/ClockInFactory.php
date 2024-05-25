<?php

namespace Database\Factories;

use App\Models\ClockIn;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClockInFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClockIn::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'lat' => $this->faker->latitude(),
            'lon' => $this->faker->longitude(),
            'user_id' => User::all()->random()->id,
            'timestamp' => strtotime('now'),
        ];
    }
}
