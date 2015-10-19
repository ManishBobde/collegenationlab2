<?php namespace App\CN\CNEvents;

use Illuminate\Database\Eloquent\Model;

class Events extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='eventId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['eventTitle','eventDescription','startDate','endDate','startTime','endTime','eventImageUrl','isRead'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['msg_read'];
    // protected $hidden = ['msg_read'];

    public static $rules =array(
        'eventTitle' => 'required',
        'eventDescription' => 'required',
        'startDate' => 'required',
        'startTime' => 'required',
        'eventImageUrl' => 'image'
    );

}
