<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'description' => $this->description,
            'amount' => (float) $this->amount,
            'currency' => $this->currency,
            'date' => $this->date->format('Y-m-d'),
            'category' => $this->category,
            'icon' => $this->icon,
            'aiSuggested' => (bool) $this->ai_suggested,
            'isPrivate' => (bool) $this->is_private,
        ];
    }
}
