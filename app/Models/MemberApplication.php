<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberApplication extends Model
{
    use HasFactory;
    protected $table = 'member_application';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'birth_place',
        'citizenship',
        'civil_status',
        'spouse_name',
        'provincial_address',
        'mailing_address',
        'email',
        'phone_number',
        'tax_id_number',
        'date_employed',
        'position',
        'nature_of_work',
        'balance',
        'amount_of_share',
        'school_id_photo',
        'valid_id_photo',
        'valid_id_type',
        'status',
    ];

    protected $dates = [
        'birth_date',
        'date_employed',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function client(){
        return $this->hasOne(Client::class);
    }
}
