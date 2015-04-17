<?php namespace Butler\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'messages';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['message'];

	/**
	 * One Message belongs to one Conversation
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function conversation()
	{
		return $this->belongsTo('Butler\Model\Conversations');
	}

	/**
	 * One Message belongs to one User (creator)
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function creator()
	{
		return $this->belongsTo('Butler\Models\User', 'user_id');
	}

	/**
	 * @param $query
	 * @param $value
	 * @return mixed
     */
	public function scopeOfConversation($query, $value)
	{
		return $query->where('conversation_id', $value)->orderBy('created_at');
	}
}
