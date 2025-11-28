<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['title' => '1984', 'author' => 'George Orwell', 'published_year' => 1945 , 'is_available' => True],
            ['title' => 'Sousou No Frieren', 'author' => 'Kanehito Yamada', 'published_year' => 2020, 'is_available' => True],
            ['title' => 'No Longer Human', 'author' => 'Osamu Dazai', 'published_year' => 1948, 'is_available' => True]
        ];
        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
