<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_application', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('provincial_address')->nullable();
            $table->string('city_address')->nullable();
            $table->string('email')->nullable();

            $table->bigInteger('phone_number')->nullable();
            $table->string('tax_id_number');
            $table->date('date_employed')->nullable();
            $table->string('position')->nullable();
            $table->string('nature_of_work')->nullable();
            $table->decimal('amount_of_share', 15, 2)->nullable();

            $table->string('school_id_photo', 255);
            $table->string('valid_id_photo', 255);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_application');
    }
};
