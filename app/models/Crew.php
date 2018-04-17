<?php
declare(strict_types=1);
namespace tdc\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Crew extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
	protected static $logOnlyDirty = true;

    public function faction()
    {
        return $this->belongsTo(Faction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class)->withTimestamps();
    }
}
