<?php

namespace TestApp;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends Model
{

    use LogsActivity;

    protected $table = "teams";

    protected $fillable = ['name','user_id'];

    protected static $logFillable = true;

    protected $hidden = ["created_at", "updated_at"];

    public function User()
    {
        return $this->belongsTo('App\User','id');
    }

    public function Group()
    {
        return $this->hasMany('App\Group', 'team_id');
    }

    public function Player()
    {
        return $this->hasMany('App\Player', 'team_id');
    }
}
