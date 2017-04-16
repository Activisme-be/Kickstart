<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Types extends Model
{
    protected $table = 'types';

    protected $fillable = ['name'];
}
