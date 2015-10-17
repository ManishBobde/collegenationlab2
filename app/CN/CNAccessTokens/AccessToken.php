<?php namespace App\CN\CNAccessTokens;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accesstokens';

    /**
     * primary key override
     * @var string
     */
    protected $primaryKey ='accessTokenId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['accessToken','deviceType','mediaType','osName','userId','idleTimeAuthTokenExpirationDuration','pushRegistrationId'];


}
