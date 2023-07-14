<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Wallets\WalletResource;
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
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'email_verified_at' => $this->email_verified_at,
            'profile_picture' => $this->profile_picture,
            'ktp' => $this->ktp,
            'wallet' => WalletResource::make($this->whenLoaded('wallet'))
        ];
    }
}
