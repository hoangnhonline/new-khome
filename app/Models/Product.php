<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'product';

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
                            'code',
                            'name',
                            'alias',
                            'slug', 
                            'description',
                            'parent_id', 
                            'cate_id', 
                            'image_url', 
                            'content', 
                            'price', 
                            'is_sale', 
                            'price_sale',
                            'sale_percent',                        
                            'out_of_stock',                       
                            'status', 
                            'meta_id',                       
                            'is_hot',
                            'amount_sold',
                            'inventory',
                            'display_order',
                            'created_user',
                            'updated_user',
                            'grand_id'                          
                        ];

    public static function getList($params = []){
        $query = self::where('status', 1);
        if( isset($params['parent_id']) && $params['parent_id'] ){
            $query->where('parent_id', $params['parent_id']);
        }
        if( isset($params['cate_id']) && $params['cate_id'] ){
            $query->where('cate_id', $params['cate_id']);
        }
        if( isset($params['grand_id']) && $params['grand_id'] ){
            $query->where('grand_id', $params['grand_id']);
        }
        if( isset($params['is_hot']) && $params['is_hot'] ){
            $query->where('is_hot', $params['is_hot']);
        }
        if( isset($params['is_sale']) && $params['is_sale'] ){
            $query->where('is_sale', $params['is_sale']);
        }
        $query->orderBy('product.is_hot', 'desc')->orderBy('product.id', 'desc');
        if(isset($params['limit']) && $params['limit']){
            return $query->limit($params['limit'])->get();
        }
        if(isset($params['pagination']) && $params['pagination']){
            return $query->paginate($params['pagination']);
        }                
    }
    public static function productTag( $id )
    {
        $arr = [];
        $rs = TagObjects::where( ['type' => 1, 'object_id' => $id] )->lists('tag_id');
        if( $rs ){
            $arr = $rs->toArray();
        }
        return $arr;
    }    
   
    public static function getListTag($id){
        $query = TagObjects::where(['object_id' => $id, 'tag_objects.type' => 1])
            ->join('tag', 'tag.id', '=', 'tag_objects.tag_id')            
            ->get();
        return $query;
    }   
    public function cateParent()
    {
        return $this->belongsTo('App\Models\CateParent', 'parent_id');
    }
    public function cate()
    {
        return $this->belongsTo('App\Models\Cate', 'cate_id');
    }
	public function grand()
    {
        return $this->belongsTo('App\Models\Grand', 'grand_id');
    }
    public function createdUser()
    {
        return $this->belongsTo('App\Models\Account', 'created_user');
    }
     public function updatedUser()
    {
        return $this->belongsTo('App\Models\Account', 'updated_user');
    }
}
