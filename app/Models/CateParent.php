<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CateParent extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cate_parent';	

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
    protected $fillable = [ 'name', 'alias', 'slug', 'description', 'image_url', 'display_order', 'meta_id', 'is_hot', 'status', 'created_user', 'updated_user', 'is_widget'];

    public function cates()
    {
        return $this->hasMany('App\Models\Cate', 'parent_id');
    }
    

}
