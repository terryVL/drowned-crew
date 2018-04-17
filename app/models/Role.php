<?php
declare(strict_types=1);
namespace tdc\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
	const TYPE_LEADER	 = 0;
	const TYPE_OTHER	 = 1;

    use LogsActivity;
    protected static $logAttributes = ['*'];
	protected static $logOnlyDirty = true;
	
	public function units()
	{
		return $this->hasMany(Unit::Class);
	}
}
