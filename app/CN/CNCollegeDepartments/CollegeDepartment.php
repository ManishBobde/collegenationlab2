<?php namespace App\CN\CNCollegeDepartments;

use Illuminate\Database\Eloquent\Model;

class CollegeDepartment extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'collegedepartments';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='collegeDeptId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded= ['collegeDeptId'];

}
