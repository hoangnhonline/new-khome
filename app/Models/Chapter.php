<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Chapter extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chapter';  

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
    protected $fillable = [ 'name', 'folder_id', 'slug', 'page_id', 'status', 'created_user', 'updated_user', 'book_id', 'display_order'];    
    public function folder()
    {
        return $this->belongsTo('App\Models\Folder', 'folder_id');
    }  
    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    } 
    public function pages()
    {
        return $this->hasMany('App\Models\Page', 'chapter_id');
    }     
}
