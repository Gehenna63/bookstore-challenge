<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Traits\ApiResponses;

class AuthorController extends Controller
{
    use ApiResponses;
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = new Author();
        $author->uuid = Uuid::uuid4()->toString();
        $author->name = $validated['name'];
        $author->save();

        return $this->success($author, 201);
    }

    public function index(): JsonResponse
    {
        $authors = Author::all();

        return $this->ok($authors);
    }
}
