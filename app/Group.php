<?php

namespace TestApp;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use LogsActivity;

    protected $table = "groups";

    protected $fillable = ['name','team_id','user_id'];

    protected static $logFillable = true;

    protected $hidden = ["created_at", "updated_at"];

    public function User()
    {
        return $this->belongsTo('App\User','id');
    }

    public function Player()
    {
        return $this->hasOne('App\Player', 'group_id');
    }
}
