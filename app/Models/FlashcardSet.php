<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashcardSet extends Model
{
    use HasFactory;

    // Add 'user_id' to the fillable attributes to allow mass assignment
    protected $fillable = ['name', 'user_id'];

    /**
     * Relationship to the Flashcards model
     */
    public function flashcards()
    {
        return $this->hasMany(Flashcard::class, 'flashcard_set_id');
    }

    /**
     * Relationship to the User model
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
