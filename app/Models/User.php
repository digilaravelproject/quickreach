<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Google ID aur Avatar add kar diya
    protected $fillable = ['name', 'email', 'password', 'phone', 'is_admin', 'google_id', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'google_id' => 'string', // Google ID handle karne ke liye
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    // Relationships (Existing - Keep them as they are)
    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class);
    }
    public function registrations(): HasMany
    {
        return $this->hasMany(QrRegistration::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
