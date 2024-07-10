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
        Schema::create('articles', function (Blueprint $table) {
            $table->id(); // auto primary key
            $table->string('headline',255);
            $table->string('subject',76);
            $table->boolean('istopnews')->default(false);
            $table->text('text');
            $table->string('image',255);
            $table->integer('visits')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('rejected')->default(false);

            // user_id to be added later


            // timestaps (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
