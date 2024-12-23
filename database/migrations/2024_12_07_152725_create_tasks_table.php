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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Task title
            $table->boolean('is_done')->default(false); // Task status
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key column
            $table->foreign('user_id') // Foreign key constraint
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->timestamps(); // Created and updated timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key
            $table->dropColumn('user_id');    // Drop the user_id column
        });

        Schema::dropIfExists('tasks');
    }
};
