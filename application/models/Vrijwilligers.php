<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vrijwilligers extends Model
{
	use SoftDeletes;

    protected $fillable = ['name', 'email'];
}
