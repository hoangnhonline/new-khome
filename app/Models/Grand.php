<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Grand extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'grand';	

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
    protected $fillable = [ 'name', 'alias', 'slug', 'description', 'image_url', 'parent_id', 'display_order', 'meta_id', 'is_hot', 'status', 'created_user', 'updated_user', 'is_widget', 'cate_id'];
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'grand_id');
    }
    public function cate()
    {
        return $this->belongsTo('App\Models\Cate', 'cate_id');
    }
    public function cateParent()
    {
        return $this->belongsTo('App\Models\CateParent', 'parent_id');
    }
    public static function getList($parent_id = null, $cate_id = null){
        $query =  self::where('status', 1);
        if( $parent_id ){
            $query->where('parent_id', $parent_id);
        } 
        if( $cate_id ){
            $query->where('cate_id', $cate_id);
        } 
        return $query->orderBy('is_hot', 'desc')->orderBy('display_order')->get();
    }
}
