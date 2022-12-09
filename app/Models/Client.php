<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'email_address',
        'phone_number',
        'country',
        'state',
        'zip_code',
        'tax_name',
        'tax_number',
    ];
}
