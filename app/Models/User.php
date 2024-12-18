<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function kecamatanElection()
    {
        return $this->hasOne(KecamatanElection::class);
    }

    public function kelurahanElection()
    {
        return $this->hasOne(KelurahanElection::class);
    }

    public function tpsElection()
    {
        return $this->hasOne(TpsElection::class);
    }

    public function tpsElectionDetails()
    {
        return $this->hasOne(TpsElectionDetail::class);
    }

    public function kelurahanDetails()
    {
        return $this->hasOne(KelurahanDetail::class);
    }
}
