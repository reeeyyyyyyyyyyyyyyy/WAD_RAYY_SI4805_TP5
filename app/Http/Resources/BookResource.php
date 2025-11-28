<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * =========1=========
     * Transformasikan resource menjadi array.
     * Pastikan untuk menyertakan semua atribut model Book.
     */
    public function toArray(Request $request): array
    {
        return [

        ];
    }
}
