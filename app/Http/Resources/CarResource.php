<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'registration_number' => $this->registration_number,
            'owner' => $this->owner->name,
            'color' => $this->color,
            'make' => $this->make->name,
            'car_model' => $this->carModel->name,
            'vin_code' => $this->vin_code,
            'year' => $this->model_year,
        ];
    }
}
