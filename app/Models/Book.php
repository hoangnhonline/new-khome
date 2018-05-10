<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Book extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'book';	

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
    protected $fillable = [ 'name', 'folder_id', 'slug', 'image_url', 'author_id', 'publish_company', 'publish_year', 'duration', 'display_order', 'status', 'created_user', 'updated_user'];    
    public function folder()
    {
        return $this->belongsTo('App\Models\Folder', 'folder_id');
    }   
    public function author()
    {
        return $this->belongsTo('App\Models\Author', 'author_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\Account', 'created_user');
    }
    public function chapters()
    {
        return $this->hasMany('App\Models\Chapter', 'book_id');
    } 
}
