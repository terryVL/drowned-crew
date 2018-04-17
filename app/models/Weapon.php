<?php
declare(strict_types=1);
namespace tdc\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Weapon extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
	protected static $logOnlyDirty = true;
	
	public function specials()
	{
		return $this->belongsToMany(Special::class)->withTimestamps();
	}

	public function units()
	{
		return $this->belongsToMany(Unit::class)->withTimestamps();
	}
}
