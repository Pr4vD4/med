<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birthday' => $this->birthday,
            'sex' => $this->sex,
            'role' => $this->role,
            'appointments' => $this->whenNotNull(UserResource::collection($this->appointments)),
            'specialities' => $this->whenNotNull(SpecialityResource::collection($this->specialities))
        ];
    }
}
