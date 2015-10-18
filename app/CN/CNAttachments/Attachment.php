<?php namespace App\CN\CNAttachments;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {

	//

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attachments';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='attachmentId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['bucket_type','bucket_name'];
    //Disabling automatic creation of created_at & updated_at fields
    public $timestamps = true;

    /**
     * Method for defining the relationship with messages table for each bucket
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

}
