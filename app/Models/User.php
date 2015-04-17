<?php namespace Butler\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * @property mixed id
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * One User has many Apps
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function apps()
	{
		return $this->hasMany('Butler\Models\App');
	}

	/**
	 * One User can belongs to many Conversation(s)
	 *
	 * @return $this
     */
	public function conversations()
	{
		return $this->belongsToMany('Butler\Models\Conversation')->withPivot('seen');
	}
}
