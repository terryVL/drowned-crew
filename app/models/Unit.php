<?php
declare(strict_types=1);
namespace tdc\models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Unit extends Model
{
	const TYPE_CHARACTER = 0;
	
    use LogsActivity;
    protected static $logAttributes = ['*'];
	protected static $logOnlyDirty = true;
	
	public function skills()
	{
		return $this->belongsToMany(Skill::class)->withTimestamps();
	}
	
	public function mounts()
	{
		return $this->hasMany(Mount::class);
	}
	
	public function weapons()
	{
		return $this->belongsToMany(Weapon::class)->withTimestamps();
	}
	
	public function crews()
	{
		return $this->belongsToMany(Crew::class)->withTimestamps();
	}
	
	public function faction()
	{
		return $this->belongsTo(Faction::class);
	}
	
	public function role()
	{
		return $this->belongsTo(role::class);
	}
}