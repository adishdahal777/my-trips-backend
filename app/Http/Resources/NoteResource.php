<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'mood' => $this->mood,
            'date' => $this->date->format('Y-m-d'),
            'color' => $this->color,
            'isPrivate' => (bool) $this->is_private,
        ];
    }
}
