<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Traits\ApiResponses;
use App\Requests\Api\V1\StoreAuthorRequest;

class AuthorController extends Controller
{
    use ApiResponses;
    
    public function store(StoreAuthorRequest $request): JsonResponse
    {
        $request->validated($request->all());

        $author = new Author();
        $author->uuid = Uuid::uuid4()->toString();
        $author->name = $request->name;
        $author->save();

        return $this->success($author, 201);
    }

    public function index(): JsonResponse
    {
        $authors = Author::all();

        return $this->ok($authors);
    }
}
