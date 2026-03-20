<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Traits\ApiResponses;

class BookController extends Controller
{
    use ApiResponses;

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:20',
            'author_uuid' => 'required|string',
        ]);

        $author = Author::where('uuid', $validated['author_uuid'])->first();

        $book = new Book();
        $book->uuid = Uuid::uuid4()->toString();
        $book->title = $validated['title'];
        $book->isbn = $validated['isbn'];
        $book->author_id = $author->id;
        $book->is_active = true;
        $book->save();

        $book->load('author');

        return $this->success($book, 201);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Book::with('author');

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($request->has('author')) {
            $authorUuid = $request->query('author');
            $author = Author::where('uuid', $authorUuid)->first();
            if ($author) {
                $query->where('author_id', $author->id);
            } else {
                return response()->json(['data' => []], 200);
            }
        }

        $books = $query->get();

        return $this->ok($books);
    }

    public function show(string $uuid): JsonResponse
    {
        $book = Book::with('author')->where('uuid', $uuid)->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found.'], 404);
        }

        return $this->ok($book);
    }
}
