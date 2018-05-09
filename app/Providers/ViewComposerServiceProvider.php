<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hash;
use App\Models\Settings;
use App\Models\Text;

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
			$view->with( [
					'settingArr' => $settingArr, 					
					'routeName' => $routeName,					
					'isEdit' => $isEdit					
			] );			
		});
	}	
}
