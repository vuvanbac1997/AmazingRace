<?php namespace App\Models;



class Challenge extends Base
{

    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'challenges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'score',
        'answer',
        'cover_image_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\ChallengePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\ChallengeObserver);
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
            'title' => $this->title,
            'content' => $this->content,
            'score' => $this->score,
            'answer' => $this->answer,
            'cover_image_id' => $this->cover_image_id,
        ];
    }

}
