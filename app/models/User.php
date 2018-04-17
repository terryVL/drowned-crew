<?php
declare(strict_types=1);
namespace tdc\models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
	const TYPES_ADMIN	 = 0;
	const TYPES_NORMAL	 = 1;
	
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    use LogsActivity;
    protected static $logAttributes = ['*'];
	protected static $logOnlyDirty = true;
	
	public function crews()
	{
		return $this->hasMany(Crew::class);
	}
	
	public function setPassword(string $password): ?string
	{
		if(strlen($password) < 6)
		{
			return 'password to short';
		}
		$this->password = Hash::make($password);
		return null;
	}
}
