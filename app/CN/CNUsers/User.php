<?php
namespace App\CN\CNUsers;

use App\CN\Interfaces\CustomModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract ,CustomModel{

	use Authenticatable, CanResetPassword ,AuthenticatesAndRegistersUsers;



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * primary key override
	 * @var string
	 */
	protected $primaryKey ='userId';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['firstName','lastName','roleId','collegeId','email',
		'password','deptId','avatarUrl','mobileNumber','registrationToken','academicYear'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * defining the relationship for roles
	 */

	public function roles(){

		return $this->belongsTo('App\CN\CNRoles\Role','roleId','roleId');
	}

	/**
	 * The permissions that belong to the user.
	 */
	public function permissions()
	{
		return $this->belongsToMany('App\CN\CNPermissions\Permission','permission_user','userId','permissionId')->withPivot('isEnabled');
	}

	public function modules()
	{
		return $this->hasMany('App\Module','moduleId');
	}

	public function department(){

		return $this->belongsTo('App\CN\CNDepartments\Department','deptId','deptId');
	}

	public function colleges(){

		return $this->hasOne('App\CN\CNColleges\College','collegeId','collegeId');
	}
}