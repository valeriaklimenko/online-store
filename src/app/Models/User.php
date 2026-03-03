<?php

namespace App\Models;

use App\Notifications\VerifyEmailQueued;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'new_email',
        'email_change_token',
        'email_change_requested_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_change_requested_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailQueued());
    }

    /**
     * Get the email address for mail notifications.
     * Override to support sending to new_email for email change verification.
     */
    public function routeNotificationForMail($notification)
    {
        if ($notification instanceof \App\Notifications\VerifyEmailChangeNotification && $this->new_email) {
            return $this->new_email;
        }

        return $this->email;
    }

    public function basket(): HasOne
    {
        return $this->hasOne(Basket::class);
    }

    public function favorites():HasOne
    {
        return $this->hasOne(Favorites::class);
    }
}
