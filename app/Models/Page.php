<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Page extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'page';  

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
    protected $fillable = [ 'content', 'folder_id', 'chapter_id', 'notes', 'status', 'created_user', 'updated_user', 'book_id', 'display_order'];    
    public function folder()
    {
        return $this->belongsTo('App\Models\Folder', 'folder_id');
    }  
    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }   
    public function chapter()
    {
        return $this->belongsTo('App\Models\Chapter', 'chapter_id');
    } 
}
