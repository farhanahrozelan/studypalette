<?php 

// Task Model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_done', 'user_id']; // Include user_id in fillable fields

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}