<?php

use App\Models\City;
use App\Models\Doctor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('DoB');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('gender', ['M', 'F']);

            $table->foreignIdFor(Doctor::class);
            $table->foreign('doctor_id')->on('doctors')->references('id');

            $table->foreignIdFor(City::class);
            $table->foreign('city_id')->on('cities')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
