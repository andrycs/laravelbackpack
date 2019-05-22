<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Jenssegers\Mongodb\Eloquent\Model;

class Burt extends Model
{
    use CrudTrait;

    protected $connection = 'local';
    protected $collection = 'burts';
//    const TABLE = 'arts';

    const ATTRIBUTE_ID = '_id';
    const ATTRIBUTE_NAME = 'name';
    const ART_ID = 'art_id';
//
//    protected $table = self::TABLE;
    protected $fillable = [self::ATTRIBUTE_NAME, self::ART_ID];

}
