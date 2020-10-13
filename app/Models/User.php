<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use \Laravel\Socialite\Contracts\User as SocialiteUser;

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

    public static function findByEmailOrCreate(string $email)
    {
        $user = User::findByEmail($email);

        if (is_null($user)) {
            $user = User::forceCreate([
                'name' => Str::before($email, '@'),
                'email' => $email,
            ]);
        }

        return $user;
    }

    public static function findOrCreateAndLoginByOauth(SocialiteUser $socialiteUser)
    {
        $user = self::findByEmail($socialiteUser->getEmail());

        if (! $user) {
            $user = User::forceCreate([
                'name' => Str::words($socialiteUser->getName(), 1, ''),
                'email' => $socialiteUser->getEmail(),
                'profile_photo_path' => $socialiteUser->getAvatar(),
                'email_verified_at' => now(),
            ]);

            $team = Team::forceCreate([
                'user_id' => $user->getKey(),
                'name' => $user->name."'s Team",
                'personal_team' => true,
            ]);

            $user->forceFill([
                'current_team_id' => $team->id,
            ]);
        }

        Auth::login($user, true);

        return $user;
    }

    /**
     * The games this user has played.
     *
     * @return BelongsToMany
     */
    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    /**
     * Games this user has won.
     *
     * @return BelongsToMany
     */
    public function wins()
    {
        return $this->belongsToMany(Game::class)
            ->wherePivot('is_winner', true);
    }

    /**
     * Games this user has lost.
     *
     * @return BelongsToMany
     */
    public function losses()
    {
        return $this->belongsToMany(Game::class)
            ->wherePivot('is_winner', false);
    }

    /**
     * Win rate as a percentage.
     *
     * @return string
     */
    public function getRateAttribute()
    {
        if (! $this->games()->count()) {
            return '0%';
        }

        return round($this->wins()->count() / $this->games()->count() * 100) . '%';
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

    /**
     * Order users by win rate.
     *
     * @param $query
     * @return mixed
     */
    public function scopeOrderByRate($query)
    {
        return $query->withCount('wins')->orderByDesc('wins_count');
    }
}
