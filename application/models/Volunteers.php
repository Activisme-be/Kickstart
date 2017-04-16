<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Volunteers extends Model
{
    use SoftDeletes;

    protected $table = 'volunteers';

    protected $fillable = ['name', 'email'];
}
