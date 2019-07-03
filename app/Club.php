<?php

namespace TestApp;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Club extends Model
{
    use LogsActivity;

    protected $table = "clubs";

    protected $fillable = ['name','user_id'];

    protected static $logFillable = true;

    protected $hidden = ["created_at", "updated_at"];

    public function User()
    {
        return $this->hasOne('App\User','id');
    }

}
