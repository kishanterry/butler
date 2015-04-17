<?php namespace Butler\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'conversations';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title'];

	/**
	 * One Conversation belongs to a User (who started/created it)
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function owner()
	{
		return $this->belongsTo('Butler\Models\User', 'created_by');
	}

	/**
	 * A Conversation belongs to many User(s) involved
	 *
	 * @return $this
     */
	public function users()
	{
		return $this->belongsToMany('Butler\Models\User')->withPivot('seen');
	}

	/**
	 * A Conversation can have many Message(s)
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function messages()
	{
		return $this->hasMany('Butler\Models\Message')->orderBy('created_at');
	}
}
