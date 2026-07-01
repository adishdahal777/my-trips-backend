<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteStopResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'label' => $this->label,
            'name' => $this->name,
            'lat' => (float) $this->lat,
            'lng' => (float) $this->lng,
            'color' => $this->color,
        ];
    }
}
