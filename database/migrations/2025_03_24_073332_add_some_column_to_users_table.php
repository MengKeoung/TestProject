<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('last_name');
            $table->string('telegram')->nullable()->after('phone');
            $table->string('image')->nullable()->after('telegram');
            $table->string('user_id')->nullable();

            // Modify existing column (email)
            $table->string('email')->nullable()->change();

            // Add soft deletes
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
        Schema::table('users', function (Blueprint $table) {
            // Drop added columns
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('telegram');
            $table->dropColumn('image');
            $table->dropColumn('user_id');

            // Revert email column changes (if needed)
            $table->string('email')->nullable(false)->change();

            // Remove soft deletes
            $table->dropSoftDeletes();
        });
    }
}