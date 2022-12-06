<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'userid',
        'amount',
        'payment_id',
        'processor',
        'payment_for',
        'status'
    ];

    public function user()  {
        return $this->belongsTo(User::class, 'userid');
    }

    public function prepare() {
        $this->editUrl = route('payments.edit', ['id' => $this->id]);
        $this->invoiceUrl = route('payments.invoice', ['id' => $this->id]);
        $this->amount = format_currency($this->amount);
        $this->invoiceTitle = config('billing-invoice', 'INVOICE-').$this->id;
        $this->userName = $this->user->name;
        $this->userAvatar = ($this->user->avatar) ?  storage_url($this->user->avatar, 100) : url('images/avatar.png');
        $this->userEmail = $this->user->email;
        return $this;
    }
}
