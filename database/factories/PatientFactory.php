<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'first_name'=>$this->faker->firstName,
            'last_name'=>$this->faker->lastName,
            'city_id' => $this->faker->numberBetween(1, 10),
            'DoB'=>$this->faker->date,
            'email'=>$this->faker->email,
            'phone'=>$this->faker->phoneNumber,
            'gender'=>'M',
            'doctor_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
