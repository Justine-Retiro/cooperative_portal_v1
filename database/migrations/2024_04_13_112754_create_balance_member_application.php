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
            $table->unsignedDecimal('balance', 15, 2)->default(0)->after('amount_of_share');
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
            $table->dropColumn(['balance']);
        });
    }
};
