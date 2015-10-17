<?php namespace App\CN\CNSubscription;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {

    //

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='subscriptionId';

    public function users(){

        return $this->hasMany('App\CN\CNUsers\User','collegeId','collegeId');

    }

}