<?php
declare(strict_types=1);
namespace tdc\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Special extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
	protected static $logOnlyDirty = true;
	
	public function weapons()
	{
		return $this->belongsToMany(Weapon::class)->withTimestamps();
	}
}
