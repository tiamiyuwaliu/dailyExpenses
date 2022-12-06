<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'trial_days',
        'monthly_price',
        'yearly_price',
        'visibility',
        'position',
        'features',
        'taxes',
        'coupons',
        'status'
    ];

    public function users() {
        return $this->hasMany(User::class, 'plan');
    }
}
