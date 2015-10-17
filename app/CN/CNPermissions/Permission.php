<?php namespace App\CN\CNPermissions;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	//
    public $timestamps = false;

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='permissionId';

    //protected $fillable =['isEnabled'];


}
