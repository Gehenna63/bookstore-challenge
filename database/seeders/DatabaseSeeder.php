<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $orwell = Author::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => 'George Orwell',
        ]);

        $tolkien = Author::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => 'J.R.R. Tolkien',
        ]);

        $asimov = Author::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => 'Isaac Asimov',
        ]);

        Book::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => '1984',
            'isbn' => '978-0451524935',
            'author_id' => $orwell->id,
        ]);

        Book::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => 'Animal Farm',
            'isbn' => '978-0451526342',
            'author_id' => $orwell->id,
        ]);

        Book::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => 'The Lord of the Rings',
            'isbn' => '978-0618640157',
            'author_id' => $tolkien->id,
        ]);

        Book::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => 'The Hobbit',
            'isbn' => '978-0547928227',
            'author_id' => $tolkien->id,
        ]);

        Book::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => 'Foundation',
            'isbn' => '978-0553293357',
            'author_id' => $asimov->id,
        ]);

        Book::create([
            'uuid' => Uuid::uuid4()->toString(),
            'title' => 'I, Robot',
            'isbn' => '978-0553294385',
            'author_id' => $asimov->id,
        ]);
    }
}
