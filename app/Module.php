<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='moduleId';
}
