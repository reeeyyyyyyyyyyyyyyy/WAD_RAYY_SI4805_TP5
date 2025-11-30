<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;
use App\Http\Resources\BookResource;

class BooksController extends Controller
{
    /**
     * ==========1===========
     * Tampilkan daftar semua buku
     */
    public function index()
    {
        $books = Book::all();
        return BookResource::collection($books);
    }

    /**
     * ==========2===========
     * Simpan buku baru ke dalam penyimpanan.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer|digits:4|min:1000|max:' . date('Y'),
            'is_available' => 'boolean'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'published_year' => $request->published_year,
            'is_available' => $request->is_available ?? true
        ]);

        return response()->json([
            'message' => 'Book created successfully',
            'data' => new BookResource($book)
        ], 201);
    }

    /**
     * =========3===========
     * Tampilkan detail buku tertentu.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'book not found'], 404);
        }
        return new BookResource($book);
    }

    /**
     * =========4===========
     * Fungsi untuk memperbarui data buku tertentu
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'published_year' => 'sometimes|required|integer|digits:4|min:1000|max:' . date('Y'),
            'is_available' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please Check Your Request',
                'errors' => $validator->errors()
            ], 422);
        }

        $book->update([
            'title' => $request->title ?? $book->title,
            'author' => $request->author ?? $book->author,
            'published_year' => $request->published_year ?? $book->published_year,
            'is_available' => $request->has('is_available') ? $request->is_available : $book->is_available
        ]);

        return response()->json([
            'message' => 'Book updated successfully',
            'data' => new BookResource($book)
        ], 200);
    }

    /**
     * =========5===========
     * Hapus buku tertentu dari penyimpanan.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'book not found'], 404);
        }
        $book->delete();
        return response()->json(['message' => 'book delete successfully'], 200);
    }

    /**
     * =========6===========
     * Ubah status ketersediaan buku (ubah field is_available)
     */
    public function borrowReturn(string $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        $book->update([
            'is_available' => !$book->is_available
        ]);

        $action = $book->is_available ? 'returned' : 'borrowed';

        return response()->json([
            'message' => "Book {$action} successfully",
            'data' => new BookResource($book)
        ], 200);
    }
}
