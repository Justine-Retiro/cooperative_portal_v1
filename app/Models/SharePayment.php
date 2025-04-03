<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharePayment extends Model
{
    use HasFactory;
    public $table = 'share_payment';
    protected $fillable = [
        'id', 
        'payment_id', 
        'remarks'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharePayment_pivot()
    {
        return $this->hasMany(SharePayment::class, 'payment_id');
    }
}
