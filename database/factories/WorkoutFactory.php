<?php

namespace Database\Factories;

use App\Models\Workout;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Workout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'workout_length' => $this->faker->time($format = 'H:i:s', $max = '02:00:00'),
            'workout_date' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now'),
        ];
    }
}
