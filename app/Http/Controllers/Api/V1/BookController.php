<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Traits\ApiResponses;
use App\Requests\Api\V1\StoreBookRequest;

class BookController extends Controller
{
    use ApiResponses;

    public function store(StoreBookRequest $request): JsonResponse
    {
        $request->validated($request->all());
        
        $author = Author::where('uuid', $request->author_uuid)->first();

        $book = new Book();
        $book->uuid = Uuid::uuid4()->toString();
        $book->title = $request->title;
        $book->isbn = $request->isbn;
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
