<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Base
{

    use SoftDeletes;

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
        'id_company',

        'profile_image_id',
        'is_activated',

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

    // Relations
    public function lastNotification()
    {
        return $this->belongsTo(\App\Models\LastNotification::class, 'last_notification_id', 'id');
    }

    public function profileImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'profile_image_id');
    }

    public function players()
    {
        return $this->hasMany(App\Models\Player::class, 'id', 'id_team');
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'id_company', 'id');
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
            'id_company' => $this->id_company,
            'last_notification_id' => $this->last_notification_id,
            'api_access_token' => $this->api_access_token,
            'profile_image_id' => $this->profile_image_id,
            'is_activated' => $this->is_activated,
            'remember_token' => $this->remember_token,
        ];
    }

}
