<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class HotCate extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'hot_cate';	

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
    protected $fillable = ['title', 'type', 'display_order', 'status', 'object_id'];
   
}
