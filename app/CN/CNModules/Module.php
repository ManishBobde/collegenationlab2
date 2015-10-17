<?php

namespace App\CN\CNModules;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='moduleId';
}
