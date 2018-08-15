<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'id_coach',
        'id_team',
        'cover_image_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\PlayerPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\PlayerObserver);
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
            'name' => $this->name,
            'id_coach' => $this->id_coach,
            'id_team' => $this->id_team,
            'cover_image_id' => $this->cover_image_id,
        ];
    }

}
