<?php namespace App\CN\CNDepartments;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='deptId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['deptName','deptYear'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['msg_read'];

    /**
     * Method for defining relationship with each user associated with department
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\CN\CNUsers\User','userId','userId');
    }

}
