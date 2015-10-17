<?php namespace App\CN\CNRoles;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	//
    public $timestamps = false;

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='roleId';

    public function permissions()
    {
        return $this->hasManyThrough('App\CN\CNPermissions\Permission', 'App\CN\CNUsers\User','roleId','userId');
    }

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\CN\CNUsers\User');
    }

}
