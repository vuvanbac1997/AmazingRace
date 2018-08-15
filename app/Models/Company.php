<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'description',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\CompanyPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\CompanyObserver);
    }

    // Relations
    public function teams(){
        return $this->hasMany(App\Model\Team::class, 'id','id_company');
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
            'address' => $this->address,
            'phone' => $this->phone,
            'description' => $this->description,
        ];
    }

}
