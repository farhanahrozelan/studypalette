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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('key_points')->nullable();
            $table->text('notes')->nullable();
            $table->text('summary')->nullable();
            $table->unsignedBigInteger('user_id'); // Add user_id column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key relationship
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations. 
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
        $table->dropColumn(['key_points', 'notes', 'summary']); // Remove the columns if rolling back
        $table->dropForeign(['user_id']); // Drop foreign key
        $table->dropColumn('user_id');    // Drop user_id column
    });
        }
};
