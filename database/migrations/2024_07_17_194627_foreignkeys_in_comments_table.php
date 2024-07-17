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
                   ->onUpdate('cascade')->nullOnDelete(); // on delete, the user_id is set to NULL
            
            $table->foreign('article_id')
                   ->references('id')->on('articles')
                   ->onUpdate('cascade')->onDelete('cascade'); // on delete all comments are deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {

            /// Drop the foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['article_id']);
            
            // Drop the columns
            $table->dropColumn('user_id');
            $table->dropColumn('article_id');
        });
    }
};
