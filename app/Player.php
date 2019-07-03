<?php

namespace TestApp;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\File;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Activitylog\Traits\LogsActivity;

class Player extends Model implements HasMedia
{
    use HasMediaTrait, LogsActivity;

    protected $table = "players";

    protected $fillable = ['name','image','group_id','team_id','user_id'];

    protected static $logFillable = true;

    protected $hidden = ["created_at", "updated_at"];

    public function User()
    {
        return $this->belongsTo('App\User','id');
    }
}
