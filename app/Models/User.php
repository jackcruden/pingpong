<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Return a user by their email address.
     *
     * @param $email
     * @return mixed
     */
    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    /**
     * Retrieve user by GitHub ID.
     *
     * @param $id
     * @return mixed
     */
    public static function findByGitHubId($id)
    {
        return self::where('github_id', $id)->first();
    }

    /**
     * The games this user has played.
     *
     * @return HasMany
     */
    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if (Str::contains($this->profile_photo_path, 'http')) {
            return $this->profile_photo_path;
        }

        return $this->profile_photo_path
            ? Storage::disk($this->profilePhotoDisk())->url($this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    public function scopeOrderByRatio($query)
    {
        return $query->orderBy('pivot_is_winner');
    }

    /**
     * Number of game wins.
     *
     * @return int
     */
    public function getWinsAttribute()
    {
        return $this->games()->wherePivot('is_winner', true)->count();
    }

    /**
     * Number of game losses.
     *
     * @return int
     */
    public function getLossesAttribute()
    {
        return $this->games()->wherePivot('is_winner', false)->count();
    }
}
