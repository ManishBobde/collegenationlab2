<?php namespace App\CN\CNBuckets;

use Illuminate\Database\Eloquent\Model;

class Bucket extends Model {

	//

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'buckets';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='bucketId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['bucket_type','bucket_name'];
    //Disabling automatic creation of created_at & updated_at fields
    public $timestamps = false;

    /**
     * Method for defining the relationship with messages table for each bucket
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(){

        return $this->hasMany('App\CN\CNMessages\Messages', 'foreign_key', 'local_key');

    }
}
