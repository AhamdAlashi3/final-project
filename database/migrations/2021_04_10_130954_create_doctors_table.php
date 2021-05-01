<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('specialization');
            $table->string('DoB');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('gender', ['M', 'F']);
            $table->boolean('active');
            $table->string('image', '145')->nullable();
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
        Schema::dropIfExists('doctors');
    }
}
