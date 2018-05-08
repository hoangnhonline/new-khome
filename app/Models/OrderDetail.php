<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OrderDetail extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_detail';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'sp_id',
        'so_luong',
        'don_gia',        
        'tong_tien'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'sp_id');
    }
        
}
