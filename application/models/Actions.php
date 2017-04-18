<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class 
 */
class Actions extends Model
{
    use SoftDeletes;

    /**
     * The database table 
     *
     * @return string
     */
    protected $table = 'links';

    /**
     * Mass-assign fields for tha database table. 
     *
     * @return array
     */
    protected $fillable = ['author_id', 'type_id', 'link', 'name'];

    public function types()
    {
        return $this->belongsTo('Types', 'type_id');
    }
}
