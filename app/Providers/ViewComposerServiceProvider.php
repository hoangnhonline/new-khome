<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hash;
use App\Models\Settings;
use App\Models\Text;
use App\Models\Author;
use App\Models\Account;
use App\Models\Folder;
use Auth, Session;
class ViewComposerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//Call function composerSidebar
		$this->composerMenu();	
		
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Composer the sidebar
	 */
	private function composerMenu()
	{
		view()->composer( '*' , function( $view ){	
	        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
	        $routeName = \Request::route()->getName();
	        $isEdit = Auth::check();
	        $authorList = Author::all();
	        $folderList = Folder::orderBy('display_order', 'asc')->get();
	        $userList = Account::all();
			$view->with( [
					'settingArr' => $settingArr, 					
					'routeName' => $routeName,					
					'isEdit' => $isEdit,
					'userList' => $userList,
					'authorList' => $authorList,
					'folderList' => $folderList					
			] );			
		});
	}	
}
