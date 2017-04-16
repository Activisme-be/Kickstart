<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actions extends Model
{
    use SoftDeletes;

    protected $table = 'links';

    protected $fillable = ['author_id', 'type_id', 'link', 'name'];

    public function types()
    {
        return $this->belongsTo('Types', 'type_id');
    }
}
