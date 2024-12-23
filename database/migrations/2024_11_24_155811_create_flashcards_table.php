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
    Schema::create('flashcards', function (Blueprint $table) {
        $table->id();
        $table->foreignId('flashcard_set_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('title')->nullable();
        $table->text('question');
        $table->text('answer');
        $table->timestamps();
    });
     }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcards'); // Drop the flashcards table if rolling back
    }
};
