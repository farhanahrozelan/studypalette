<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Note;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch the first user
        $user = User::first();

        if ($user) {
            // Create a single note for the user
            Note::create([
                'title' => 'Sample Note',
                'key_points' => 'This note contains key points for testing.',
                'notes' => 'This is a sample note added for testing purposes.',
                'summary' => 'A short summary of the note.',
                'user_id' => $user->id, // Associate the note with the user
                'status' => 'approved', // Default status
            ]);
        }
    }
}
