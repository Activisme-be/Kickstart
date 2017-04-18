<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Types extends Model
{
    protected $table = 'types';

	/**
	 * The mass-assign fields for the database table.
	 *
	 * @var array
	 */
    protected $fillable = ['name'];
}
