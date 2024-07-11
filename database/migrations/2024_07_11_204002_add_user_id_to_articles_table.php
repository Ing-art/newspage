<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // add the column user-Id
            Schema::table('articles', function(Blueprint $table){
                $table->unsignedBigInteger('user_id')->nullable()->after('rejected');

                // relationship
                $table->foreign('user_id')
                      ->references('id')->on('users')
                      ->onUpdate('cascade')->onDelete('restrict');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Reverse migration
            $table->dropForeign('articles_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
};
