<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CustomerAddress extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'customer_address';

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
                            'customer_id',
                            'fullname',                                                         
                            'city_id',
                            'district_id',
                            'ward_id',
                            'address',
                            'phone',
                            'email',
                            'is_primary',                            
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
    public static function getList($customer_id, $is_primary = null){
        $query = self::where('customer_id', $customer_id);
        if($is_primary){
            $query->where('is_primary', 1);
        }
        return $query->orderBy('is_primary', 'desc')->orderBy('id', 'desc')->get();
    }
}
