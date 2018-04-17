<?php
declare(strict_types=1);
namespace tdc\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Faction extends Model
{
	const TYPE_NORMAL = 0;
	
    use LogsActivity;
    protected static $logAttributes = ['*'];
	protected static $logOnlyDirty = true;
	
	public function units()
	{
		return $this->hasMany(Unit::class);
	}
	
	public function crews()
	{
		return $this->hasMany(Crew::class);
	}
}
