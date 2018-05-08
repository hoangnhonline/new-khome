<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cate extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cate';	

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
    protected $fillable = [ 'name', 'alias', 'slug', 'description', 'image_url', 'parent_id', 'display_order', 'meta_id', 'is_hot', 'status', 'created_user', 'updated_user', 'is_widget'];
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'cate_id');
    }
    public function grand()
    {
        return $this->hasMany('App\Models\Grand', 'cate_id');
    }
    public function cateParent()
    {
        return $this->belongsTo('App\Models\CateParent', 'parent_id');
    }
    public static function getList($parent_id = null){
        $query =  self::where('status', 1);
        if( $parent_id ){
            $query->where('parent_id', $parent_id);
        } 
        return $query->orderBy('is_hot', 'desc')->orderBy('display_order')->get();
    }
}
