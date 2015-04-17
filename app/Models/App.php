<?php namespace Butler\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed app_secret
 * @property mixed app_key
 */
class App extends Model {

	/**
	 * Database Table
	 *
	 * @var string
	 */
	protected $table = 'apps';

	/**
	 * Mass Assignable Fields
	 *
	 * @var array
	 */
	protected $fillable = [
		'app_id',
		'name',
		'app_key',
		'app_secret',
		'enabled',
	];

	/**
	 * One App belongs to a User
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function user()
	{
		return $this->belongsTo('Butler\Models\User');
	}

	/**
	 * One App can have manu Channel(s)
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function channels()
	{
		return $this->hasMany('Butler\Models\Channel');
	}

	/**
	 * @param $query
	 * @param $user_id
	 * @return mixed
     */
	public function scopeOfUser($query, $user_id)
	{
		return $query->where('user_id', $user_id);
	}

	/**
	 * @param $query
	 * @return mixed
     */
	public function scopeEnabled($query)
	{
		return $query->where('enabled', true);
	}
}
