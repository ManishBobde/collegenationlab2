<?php namespace App\CN\CNNews;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='newsId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['newsTitle','newsDescription','newsImageUrl','creatorId','collegeId'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
   // protected $hidden = ['msg_read'];

    public static $rules =array(
        'newsTitle' => 'required',
        'newsDescription' => 'required',
        'newsImageUrl'=>'image'
    );

}
