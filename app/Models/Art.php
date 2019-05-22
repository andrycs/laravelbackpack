<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Jenssegers\Mongodb\Eloquent\Model;

class Art extends Model
{
    use CrudTrait;

    protected $connection = 'local';
    protected $collection = 'arts';
//    const TABLE = 'arts';

    const ATTRIBUTE_ID = '_id';
    const ATTRIBUTE_NAME = 'name';
    const TAG_ID = 'tag_id';
//
//    protected $table = self::TABLE;
    protected $fillable = [self::ATTRIBUTE_NAME, self::TAG_ID];

    public function burt()
    {
        return $this->belongsTo(Burt::class);
    }

}
