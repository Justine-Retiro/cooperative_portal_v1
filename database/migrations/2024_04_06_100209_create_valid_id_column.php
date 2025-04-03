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
        Schema::table('member_application', function (Blueprint $table) {
            $table->string('valid_id_type')->nullable()->after('valid_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_application', function (Blueprint $table) {
            $table->dropColumn('valid_id_type');
        });
    }
};
