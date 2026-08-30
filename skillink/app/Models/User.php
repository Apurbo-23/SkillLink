<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Availability;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'credits',
        'profile_slug',
        'is_admin',
        'is_suspended',
    ];

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            if (empty($user->profile_slug)) {
                $user->profile_slug = static::generateUniqueSlug($user->name);
            }
        });
    }

    protected static function generateUniqueSlug(string $name): string
    {
        do {
            $slug = Str::slug($name).'-'.Str::lower(Str::random(6));
        } while (static::where('profile_slug', $slug)->exists());

        return $slug;
    }

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
            'credits' => 'integer',
            'is_admin' => 'boolean',
            'is_suspended' => 'boolean',
        ];
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function swapRequestsSent(): HasMany
    {
        return $this->hasMany(SwapRequest::class, 'requester_id');
    }

    public function swapRequestsReceived(): HasMany
    {
        return $this->hasMany(SwapRequest::class, 'provider_id');
    }

    public function creditTransactions(): HasMany
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function ratingsReceived(): HasMany
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }

    public function ratingsGiven(): HasMany
    {
        return $this->hasMany(Rating::class, 'rater_id');
    }

    public function endorsementsReceived(): HasMany
    {
        return $this->hasMany(Endorsement::class, 'endorsed_user_id');
    }

        public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function portfolioItems(): HasMany
    {
        return $this->hasMany(PortfolioItem::class);
    }

    public function skillOfferings(): HasMany
    {
        return $this->hasMany(SkillOffering::class);
    }

    /**
     * Average rating out of 5, or null if nobody's rated this user yet.
     */
    public function averageRating(): ?float
    {
        $average = $this->ratingsReceived()->avg('score');

        return is_null($average) ? null : round($average, 1);
    }

    /**
     * Endorsement counts grouped by skill, e.g. ['Guitar' => 3, 'Excel' => 1].
     */
    public function endorsementCountsBySkill(): array
    {
        return $this->endorsementsReceived()
            ->selectRaw('skill, count(*) as total')
            ->groupBy('skill')
            ->pluck('total', 'skill')
            ->toArray();
    }

    public function publicProfileUrl(): string
    {
        return route('profile.public', ['slug' => $this->profile_slug ?? $this->id]);
    }
}
