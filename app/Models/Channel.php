<?php namespace Butler\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model {

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
	];

	/**
	 * One Channel belongs to an App
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function app()
	{
		return $this->belongsTo('Butler\Models\App');
	}
}
