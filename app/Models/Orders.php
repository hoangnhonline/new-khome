<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Orders extends Model  {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'orders';

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
      'id',
      'customer_id',
      'tong_tien',      
      'tong_sp',
      'status',
      'method_id',
      'coupon_id',
      'giam_gia',
      'tien_thanh_toan',
      'phi_van_chuyen',      
      'phi_cod',
      'fullname',      
      'da_thanh_toan',
      'address_id',
      'branch_id',
      'date_delivery',
      'time_delivery',
      'phi_phuc_vu',
      'notes'
    ];

    public function order_detail()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\CustomerAddress', 'id', 'address_id');
    }
    public function addressL()
    {
        return $this->hasOne('App\Models\CustomerAddress', 'id', 'address_id');
    }
}
