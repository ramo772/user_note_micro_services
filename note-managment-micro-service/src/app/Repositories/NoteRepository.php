<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Support\Collection;

class NoteRepository extends Repository
{
    public function model(): string
    {
        return Note::class;
    }
}
