<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Folder extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'folder';

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
                            'user_id',
                            'display_order'
                            ];
    public function books()
    {
        return $this->hasMany('App\Models\Book', 'folder_id');
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
