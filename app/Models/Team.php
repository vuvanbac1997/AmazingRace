<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class Team extends AuthenticatableBase
{   
    use HasApiTokens;

    const DEFAULT_PASSWORD = 'team_api';

    //use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'display_name',
        'password',
        'cover_image_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\TeamPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\TeamObserver);
    }

    public function findForPassport($identifier)
    {
        return $this->where('username', $identifier)->first();
    }

    public function getAuthPassword() 
    { 
        return Hash::make(self::DEFAULT_PASSWORD); 
 
    }

    public function accessTokens() 
    { 
        return $this->hasMany(\App\Models\OauthAccessToken::class, 'user_id', 'id'); 
    } 
    // Relations
    public function coverImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'cover_image_id');
    }

    

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'display_name' => $this->display_name,
            'password' => $this->password,
            'cover_image_id' => $this->cover_image_id,
        ];
    }

}
