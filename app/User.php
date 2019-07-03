<?php

namespace TestApp;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasMediaTrait, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'email','password', 'role', 'image', 'ip'];

    protected static $logFillable = true;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', "created_at", "updated_at"];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getFullNameAttribute($value)
    {
       return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Club()
    {
        return $this->hasMany('App\Club', 'user_id');
    }

    public function Team()
    {
        return $this->hasMany('App\Team', 'user_id');
    }

    public function Group()
    {
        return $this->hasMany('App\Group', 'user_id');
    }

    public function Player()
    {
        return $this->hasMany('App\Player', 'user_id');
    }
    
    public function registerMediaCollections()
    {
        $this->addMediaCollection('avatar')
            ->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpeg';
            })
            ->registerMediaConversions(function (Media $media){
                $this->addMediaConversion('card')
                    ->width(368)
                    ->height(232);
                $this->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });
    }
}
