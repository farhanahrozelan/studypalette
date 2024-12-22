<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = ['flashcard_set_id', 'title', 'question', 'answer'];

    public function flashcardSet()
    {
        return $this->belongsTo(FlashcardSet::class, 'flashcard_set_id');
    }
    
}
