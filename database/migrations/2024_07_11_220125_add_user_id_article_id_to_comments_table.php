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
        Schema::table('comments', function (Blueprint $table) {
            // add user_id and article_id
            $table->unsignedBigInteger('user_id')->nullable()->after('created_at');
            $table->unsignedBigInteger('article_id')->nullable()->after('created_at');

            // relationships
            $table->foreign('user_id')
                   ->references('id')->on('users')
                   ->onUpdate('cascade')->onDelete('restrict');
            
            $table->foreign('article_id')
                   ->references('id')->on('articles')
                   ->onUpdate('cascade')->onDelete('restrict');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            //
            $table->dropForeign('comments_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('comments_article_id_foreign');
            $table->dropColumn('article_id');
        });
    }
};
