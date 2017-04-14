<?php

class Authencate extends Model 
{
	/**
	 * The database table name.
	 *
	 * @return string
	 */
	protected $table = 'users'; 

	/**
	 * The mass-assign fields for the database.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * Abilities data for the given user. 
	 *
	 * @return belongsToManyInstance
	 */
	public function abilities() 
	{
		return $this->belongsToMany(Abilities::class, '', '', '')
			->withTimestamps();
	}

	/**
	 * Permissions data for the given user.
	 *
	 * @return belongsToMany
	 */
	public function permissions()
	{
		return $this->belongsToMany(Permissions::class, '', '', '')
			->withTimestamps();
	}
}