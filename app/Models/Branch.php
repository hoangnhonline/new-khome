<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Branch extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'branch';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'name',                             
                            'alias',                             
                            'city_id',
                            'district_id',
                            'ward_id',
                            'address',
                            'phone',
                            'display_order',
                            'created_user', 
                            'updated_user'
                        ];
   
    public function createdUser()
    {
        return $this->belongsTo('App\Models\Account', 'created_user');
    }
     public function updatedUser()
    {
        return $this->belongsTo('App\Models\Account', 'updated_user');
    }
    public static function getList(){
        return self::where('status', 1)->orderBy('display_order')->get();
    }
    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id');
    }

    public function district()
    {
        return $this->hasOne('App\Models\District', 'id', 'district_id');
    }
    public function ward()
    {
        return $this->hasOne('App\Models\Ward', 'id', 'ward_id');
    }
}
