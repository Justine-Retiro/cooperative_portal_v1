<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasFactory;

    public $table = 'users';
    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'birth_date' => 'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'role_id',
        'account_number',
        'name',
        'email',
        'email_verified_at',
        'birth_date',
        'password',
        'remember_token',
        'is_from_signup',
        'is_share_paid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
    public function auth_client() {
        return $this->hasOne(Client::class);
    }
    public function hasPermission($permissionId) {
        return $this->permission_id == $permissionId;
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'account_number_id');
    }

    public function sharePayments()
    {
        return $this->hasManyThrough(
            SharePayment::class,
            Payment::class,
            'account_number_id',      // Foreign key on payments table
            'payment_id',     // Foreign key on share_payments table
            'id',             // Local key on users table
            'id'              // Local key on payments table
        );
    }
    public function transactions()
    {
        return $this->hasMany(TransactionHistory::class, 'account_number_id');
    }
}