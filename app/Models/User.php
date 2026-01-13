<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'type',
        'last_ip',
        'last_online',
        'bio',
        'website',
        'avatar',
        'email_verified_at',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'password' => 'hashed',
        ];
    }

    protected function avatar(): Attribute
    {
        return Attribute::get(function ($value) {
            if (!$value) {
                return null;
            }

            // If already full URL (Google avatar, etc.)
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                return $value;
            }

            // Local storage avatar
            return asset('storage/' . $value);
        });
    }

    public function savedArticles()
    {
        return $this->belongsToMany(Article::class, 'saved_articles')->withTimestamps();
    }
}
