<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatorCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'thumbnail'
    ];

    public function dataPlans(): HasMany
    {
        return $this->hasMany(DataPlan::class);
    }
}
