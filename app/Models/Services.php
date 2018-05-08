<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Services extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'services';

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
                            'title', 
                            'slug', 
                            'alias',                             
                            'status', 
                            'display_order', 
                            'description', 
                            'image_url',
                            'url',
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
}
