<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vrijwilligers
 */
class Vrijwilligers extends Model
{
	use SoftDeletes;

	/**
	 * The mass-assign fields for the volunteers.
	 *
	 * @var array
	 */
    protected $fillable = ['name', 'email'];
}
