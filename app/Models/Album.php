<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Album extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'album';	

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
    protected $fillable = ['name', 'image_url', 'book_id', 'folder_id'];

}
