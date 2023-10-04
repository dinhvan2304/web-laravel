<?php
// use Mail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Application Backup-ROUTES
Route::post('/backup-file',[
  'uses' => '\App\Http\Controllers\Settings\SettingsController@backupFiles',
  'as' => 'backup-files'
]);

Route::post('/backup-db',[
  'uses' => '\App\Http\Controllers\Settings\SettingsController@backupDb',
  'as' => 'backup-db'
]);

Route::post('/backup-download/{name}/{ext}',[
  'uses' => '\App\Http\Controllers\Settings\SettingsController@downloadBackup',
  'as' => 'backup-download'
]);

Route::post('/backup-delete/{name}/{ext}',[
  'uses' => '\App\Http\Controllers\Settings\SettingsController@deleteBackup',
  'as' => 'backup-delete'
]);

Route::get('/logout', [
    'uses' => '\App\Http\Controllers\Auth\LoginController@logout'
]);

// Route::get('/testMail', function () {
// 	$emails = ['tuanpt@vnpt.vn', 'minhtan@vnpt.vn'];

// 	Mail::send('emails.news', [], function($message) use ($emails){    
// 		$message->to($emails)->subject('This is test e-mail');    
// 	});
// 	dd(Mail::failures());
// });


  Route::post('/verify-2fa',[
    'as' => 'verify-2fa',
    'uses' => '\App\Http\Controllers\Profile\ProfileController@verify'
  ]);

	Route::post('/activate-2fa',[
		'uses' => '\App\Http\Controllers\Profile\ProfileController@activate',
		'as' => 'activate-2fa'
	]);

	Route::post('/enable-2fa',[
		'uses' => '\App\Http\Controllers\Profile\ProfileController@enable',
		'as' => 'enable-2fa'
	]);

	Route::post('/disable-2fa',[
		'uses' => '\App\Http\Controllers\Profile\ProfileController@disable',
		'as' => 'disable-2fa'
	]);

	Route::get('/2fa/instruction',[
		'uses' => '\App\Http\Controllers\Profile\ProfileController@instruction',
	]);


	Route::get('/',[
		'as'=> 'index',
		'uses'=> '\App\Http\Controllers\HomeController@index',
	]);


	Route::get('/dashboard/packages-rejoin',[
		'as'=> 'dashboard-packages-rejoin',
		'uses'=> '\App\Http\Controllers\HomeController@packagesRejoin',
	])->middleware('auth');
 
	Route::get('/dashboard/detail-packages',[
		'as'=> 'dashboard-detail-packages',
		'uses'=> '\App\Http\Controllers\HomeController@detailPackages',
	])->middleware('auth');

	Route::get('/dashboard/detail-competitors',[
		'as'=> 'dashboard-detail-competitors',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitors',
	])->middleware('auth');

	Route::get('/dashboard/detail-plans',[
		'as'=> 'dashboard-detail-plans',
		'uses'=> '\App\Http\Controllers\HomeController@detailPlans',
	])->middleware('auth');
	Route::get('/api/detail-plans/packages',[
		'as'=> 'api-detail-plans-packages',
		'uses'=> '\App\Http\Controllers\HomeController@detailPlansPackages',
	])->middleware('auth');
	
	Route::get('/api/favorites',[
		'as'=> 'api-favorites',
		'uses'=> '\App\Http\Controllers\HomeController@favorites',
	])->middleware('auth'); 

	Route::get('/dashboard/detail-clients',[
		'as'=> 'dashboard-detail-clients',
		'uses'=> '\App\Http\Controllers\HomeController@detailClients',
	])->middleware('auth');

	Route::get('/dashboard/detail-client-competitor',[
		'as'=> 'dashboard-detail-client-competitor',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientCompetitor',
	])->middleware('auth');
	Route::get('/dashboard/detail-competitor-competitor',[
		'as'=> 'dashboard-detail-competitor-competitor',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorCompetitor',
	])->middleware('auth');

	Route::get('/dashboard/packages',[
		'as'=> 'dashboard-packages',
		'uses'=> '\App\Http\Controllers\HomeController@packages',
	])->middleware('auth');
	Route::get('/dashboard/plans',[
		'as'=> 'dashboard-plans',
		'uses'=> '\App\Http\Controllers\HomeController@plans',
	])->middleware('auth');

	Route::get('/dashboard/competitors',[
		'as'=> 'dashboard-competitors',
		'uses'=> '\App\Http\Controllers\HomeController@competitors',
	])->middleware('auth');

	Route::get('/dashboard/clients',[
		'as'=> 'dashboard-clients',
		'uses'=> '\App\Http\Controllers\HomeController@clients',
	])->middleware('auth');

	Route::get('/dashboard/statisticcity',[
		'as'=> 'dashboard-statisticcity',
		'uses'=> '\App\Http\Controllers\HomeController@statisticcity',
	])->middleware('auth');

	Route::get('/dashboard/statisticcompetitor',[
		'as'=> 'dashboard-statisticcompetitor',
		'uses'=> '\App\Http\Controllers\HomeController@statisticcompetitor',
	])->middleware('auth');
	
	Route::get('/dashboard/statisticprovinces',[
		'as'=> 'dashboard-statisticprovinces',
		'uses'=> '\App\Http\Controllers\HomeController@statisticprovinces',
	])->middleware('auth');
	Route::get('/dashboard/statisticpackages',[
		'as'=> 'dashboard-statisticpackages',
		'uses'=> '\App\Http\Controllers\HomeController@statisticpackages',
	])->middleware('auth');
	
	Route::get('/api/statistic-city',[
		'as'=> 'api-statistic-city',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticCity',
	])->middleware('auth');
	Route::get('/api/statistic-city-list',[
		'as'=> 'api-statistic-city-list',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticCityList',
	])->middleware('auth');
	
	Route::get('/api/statistic-competitor-list',[
		'as'=> 'api-statistic-competitor-list',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticCompetitorList',
	])->middleware('auth');

	Route::get('/api/statistic-provinces',[
		'as'=> 'api-statistic-provinces',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticProvinces',
	])->middleware('auth');
	Route::get('/api/statistic-provinces-list',[
		'as'=> 'api-statistic-provinces-list',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticProvincesList',
	])->middleware('auth');

	Route::get('/dashboard/statisticclients',[
		'as'=> 'dashboard-statisticclients',
		'uses'=> '\App\Http\Controllers\HomeController@statisticclients',
	])->middleware('auth');
	
	Route::get('/api/statistic-clients',[
		'as'=> 'api-statistic-clients',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticClients',
	])->middleware('auth');
	Route::get('/api/statistic-clients-list',[
		'as'=> 'api-statistic-clients-list',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticClientsList',
	])->middleware('auth');

	Route::get('/api/statistic-packages',[
		'as'=> 'api-statistic-packages',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticPackages',
	])->middleware('auth');
	Route::get('/api/statistic-packages-list',[
		'as'=> 'api-statistic-packages-list',
		'uses'=> '\App\Http\Controllers\HomeController@userStatisticPackagesList',
	])->middleware('auth');
	
  
	Route::get('/api/user-plans',[
		'as'=> 'api-user-plans',
		'uses'=> '\App\Http\Controllers\HomeController@userPlans',
	])->middleware('auth');
	Route::get('/api/user-plans-packages',[
		'as'=> 'api-user-plans',
		'uses'=> '\App\Http\Controllers\HomeController@userPlansPackages',
	])->middleware('auth');
  
	Route::get('/api/user-clients',[
		'as'=> 'api-user-clients',
		'uses'=> '\App\Http\Controllers\HomeController@userClients',
	])->middleware('auth');
	
	Route::get('/api/user-competitors',[
		'as'=> 'api-user-competitors',
		'uses'=> '\App\Http\Controllers\HomeController@userCompetitors',
	])->middleware('auth');
	Route::get('/api/user-competitors/root',[
		'as'=> 'api-user-competitors-root',
		'uses'=> '\App\Http\Controllers\HomeController@userCompetitorsRoot',
	])->middleware('auth');
	Route::get('/api/user-clients/root',[
		'as'=> 'api-user-clients-root',
		'uses'=> '\App\Http\Controllers\HomeController@userClientsRoot',
	])->middleware('auth');
	
	Route::get('/api/user-packages',[
		'as'=> 'api-user-packages',
		'uses'=> '\App\Http\Controllers\HomeController@userPackages',
	])->middleware('auth');

	Route::get('/api/user-packages-rejoin',[
		'as'=> 'api-user-packages-rejoin',
		'uses'=> '\App\Http\Controllers\HomeController@userPackagesReJoin',
	])->middleware('auth');

	Route::get('/api/detail-packages/statistic',[
		'as'=> 'api-detail-packages-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@detailPackagesStatistic',
	])->middleware('auth');
	Route::get('/api/detail-packages/competitors',[
		'as'=> 'api-detail-packages-competitors',
		'uses'=> '\App\Http\Controllers\HomeController@detailPackagesCompetitors',
	])->middleware('auth');

	Route::get('/api/detail-competitors/competitors',[
		'as'=> 'api-detail-competitors-competitors',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsCompetitors',
	])->middleware('auth');
	Route::get('/api/detail-competitors/childs',[
		'as'=> 'api-detail-competitors-childs',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsChilds',
	])->middleware('auth');
	Route::get('/api/detail-competitors/packages',[
		'as'=> 'api-detail-competitors-packages',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsPackages',
	])->middleware('auth');
	Route::get('/api/detail-competitors/packages-win',[
		'as'=> 'api-detail-competitors-packages-win',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsPackagesWin',
	])->middleware('auth');
	Route::get('/api/detail-competitors/packages-clients',[
		'as'=> 'api-detail-competitors-packages-clients',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsPackagesClients',
	])->middleware('auth');
	Route::get('/api/detail-competitors/statistic',[
		'as'=> 'api-detail-competitors-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsStatistic',
	])->middleware('auth');
	Route::get('/api/detail-competitors/good',[
		'as'=> 'api-detail-competitors-good',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsGood',
	])->middleware('auth');
	Route::get('/api/detail-competitors/competitors-joins',[
		'as'=> 'api-detail-competitors-joins',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorsJoins',
	])->middleware('auth');

	Route::get('/api/detail-clients/competitors',[
		'as'=> 'api-detail-clients-competitors',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientsCompetitors',
	])->middleware('auth');
	Route::get('/api/detail-clients/packages',[
		'as'=> 'api-detail-clients-packages',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientsPackages',
	])->middleware('auth');
	Route::get('/api/detail-clients/plans',[
		'as'=> 'api-detail-clients-plans',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientsPlans',
	])->middleware('auth');
	Route::get('/api/detail-clients/childs',[
		'as'=> 'api-detail-clients-clients',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientsChilds',
	])->middleware('auth');

	Route::get('/api/detail-clients/statistic',[
		'as'=> 'api-detail-clients-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientsStatistic',
	])->middleware('auth');
	Route::get('/api/detail-clients/good',[
		'as'=> 'api-detail-clients-good',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientsGood',
	])->middleware('auth');

	Route::get('/api/detail-client-competitor/statistic',[
		'as'=> 'api-detail-client-competitor-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientCompetitorStatistic',
	])->middleware('auth');
	Route::get('/api/detail-client-competitor/packages',[
		'as'=> 'api-detail-client-competitor-packages',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientCompetitorPackages',
	])->middleware('auth');
	Route::get('/api/detail-client-competitor/packagesWin',[
		'as'=> 'api-detail-client-competitor-packagesWin',
		'uses'=> '\App\Http\Controllers\HomeController@detailClientCompetitorPackagesWin',
	])->middleware('auth');


	Route::get('/api/detail-competitor-competitor/statistic',[
		'as'=> 'api-detail-competitor-competitor-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorCompetitorStatistic',
	])->middleware('auth');
	Route::get('/api/detail-competitor-competitor/packages',[
		'as'=> 'api-detail-competitor-competitor-packages',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorCompetitorPackages',
	])->middleware('auth');
	Route::get('/api/detail-competitor-competitor/packagesWin',[
		'as'=> 'api-detail-competitor-competitor-packagesWin',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorCompetitorPackagesWin',
	])->middleware('auth');
	Route::get('/api/detail-competitor-competitor/packagesJoin',[
		'as'=> 'api-detail-competitor-competitor-packagesJoin',
		'uses'=> '\App\Http\Controllers\HomeController@detailCompetitorCompetitorPackagesJoin',
	])->middleware('auth');

	Route::get('/api/dashboard/statistic',[
		'as'=> 'api-dashboard-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@dashboardStatistic',
	])->middleware('auth');


	Route::get('/business',[
		'as'=> 'business',
		'uses'=> '\App\Http\Controllers\HomeController@businesses',
	])->middleware('auth');

	Route::get('/province',[
		'as'=> 'province',
		'uses'=> '\App\Http\Controllers\HomeController@provinces',
	])->middleware('auth');

	Route::get('/bidder',[
		'as'=> 'bidder',
		'uses'=> '\App\Http\Controllers\HomeController@bidder',
	])->middleware('auth');

	Route::get('/procuringEntity',[
		'as'=> 'procuringEntity',
		'uses'=> '\App\Http\Controllers\HomeController@procuringEntity',
	])->middleware('auth');

	Route::get('/category_items',[
		'as'=> 'category_items',
		'uses'=> '\App\Http\Controllers\HomeController@category_items',
	])->middleware('auth');

	Route::get('/api/manage-clients',[
		'as'=> 'manage-clients',
		'uses'=> '\App\Http\Controllers\HomeController@manageClients',
	])->middleware('auth');
	
	Route::get('/api/companies_client',[
		'as'=> 'companies_client',
		'uses'=> '\App\Http\Controllers\HomeController@getCompaniesClient',
	])->middleware('auth');

	Route::get('/api/companies_key',[
		'as'=> 'companies_key',
		'uses'=> '\App\Http\Controllers\HomeController@getCompaniesKey',
	])->middleware('auth');
	
	Route::get('/businesses',[
		'as'=> 'businesses',
		'uses'=> '\App\Http\Controllers\BusinessController@businesses',
	])->middleware('auth');

	Route::post('/businesses/store','\App\Http\Controllers\BusinessController@store_businesses')->middleware('auth');
	Route::delete('/businesses/destroy/{id}','\App\Http\Controllers\BusinessController@destroy_businesses')->middleware('auth');	
	Route::put('/businesses/edit/{id}','\App\Http\Controllers\BusinessController@edit_businesses')->middleware('auth');		

	Route::post('/competitor/store','\App\Http\Controllers\CompetitorController@store_competitor')->middleware('auth');
	Route::delete('/competitor/destroy/{id}','\App\Http\Controllers\CompetitorController@destroy_competitor')->middleware('auth');	
	Route::put('/competitor/edit/{id}','\App\Http\Controllers\CompetitorController@edit_competitor')->middleware('auth');

	Route::post('/client/store','\App\Http\Controllers\ClientController@store_client')->middleware('auth');
	Route::delete('/client/destroy/{id}','\App\Http\Controllers\ClientController@destroy_client')->middleware('auth');	
	Route::put('/client/edit/{id}','\App\Http\Controllers\ClientController@edit_client')->middleware('auth');

	Route::get('/provinces',[
		'as'=> 'provinces',
		'uses'=> '\App\Http\Controllers\ProvinceController@provinces',
	])->middleware('auth');

	Route::post('/provinces/store','\App\Http\Controllers\ProvinceController@store_provinces')->middleware('auth');
	Route::delete('/provinces/destroy/{id}','\App\Http\Controllers\ProvinceController@destroy_provinces')->middleware('auth');	
	Route::put('/provinces/edit/{id}','\App\Http\Controllers\ProvinceController@edit_provinces')->middleware('auth');	

	Route::get('/category_item',[
		'as'=> 'category_item',
		'uses'=> '\App\Http\Controllers\ItemsController@category_item',
	])->middleware('auth');

	Route::post('/items/store','\App\Http\Controllers\ItemsController@store_items')->middleware('auth');
	Route::delete('/items/destroy/{id}','\App\Http\Controllers\ItemsController@destroy_items')->middleware('auth');	
	Route::put('/items/edit/{id}','\App\Http\Controllers\ItemsController@edit_items')->middleware('auth');

	Route::get('/dashboard',[
		'as'=> 'home',
		'uses'=> '\App\Http\Controllers\Dashboard\DashboardController@dashboard',
	])->middleware('auth');


	/*
	|  Activitylog Route
	*/
	Route::resource('activity-log', '\App\Http\Controllers\Activitylog\ActivitylogController');
  /*
  |  Activitylog Route
  */


	/*
	| Profile Routes
	*/

  Route::resource('profile', '\App\Http\Controllers\Profile\ProfileController');

	Route::get('update-avatar/{id}',[
		'as' => 'update-avatar',
		'uses'=> '\App\Http\Controllers\Profile\ProfileController@showAvatar'
	]);

	Route::post('update-avatar/{id}', '\App\Http\Controllers\Profile\ProfileController@updateAvatar');

	Route::post('update-profile-login/{id}',[
		'uses'=> '\App\Http\Controllers\Profile\ProfileController@updateLogin',
		'as' => 'update-login',
	]);

#####################################ADMIN MANAGED SECTION##########################################
// Users Route
	Route::resource('user', '\App\Http\Controllers\UserController');
	Route::post('update-user-login/{id}',[
    'as' => 'user-login',
	'uses'=> '\App\Http\Controllers\UserController@userLogin']);
	Route::get('user/{id}/activity-log/',[
    'as' => 'user-activitlog',
	'uses'=> '\App\Http\Controllers\UserController@userActivityLog']);
  // Users Route


// Roles Route
	Route::resource('role', '\App\Http\Controllers\Role\RoleController');
	Route::post('/role-permission/{id}',[
		'as' => 'roles_permit',
		'uses' => '\App\Http\Controllers\Role\RoleController@assignPermission',
	]);
// Roles Route


// Permission Route
	Route::resource('permission', '\App\Http\Controllers\Permission\PermissionController');
  // Permission Route



      	Route::resource('settings','\App\Http\Controllers\Settings\SettingsController');

      	Route::post('settings/app-name/update',[
      		'as' => 'settings/app-name/update',
      		'uses' => '\App\Http\Controllers\Settings\SettingsController@appNameUpdate',
      	]);
      	Route::post('settings/app-logo/update',[
      		'as' => 'settings/app-logo/update',
      		'uses' => '\App\Http\Controllers\Settings\SettingsController@appLogoUpdate',
      	]);

      	Route::post('settings/app-theme/update',[
      		'as' => 'settings/app-theme/update',
      		'uses' => '\App\Http\Controllers\Settings\SettingsController@appThemeUpdate',
      	]);

      	Route::post('settings/stripe-payment/update',[
      		'as' => 'settings/stripe-payment/update',
      		'uses' => '\App\Http\Controllers\Settings\SettingsController@stripePaymentUpdate',
      	]);

        Route::post('settings/auth-settings/update',[
      		'as' => 'settings/auth-settings/update',
      		'uses' => '\App\Http\Controllers\Settings\SettingsController@authSettingsUpdate',
      	]);

Route::impersonate();
Auth::routes(['verify' => true]);
Route::resource('clients', App\Http\Controllers\ClientController::class);
Route::resource('competitors', App\Http\Controllers\CompetitorController::class);
Route::resource('provinces', App\Http\Controllers\ProvinceController::class);
Route::resource('packages', App\Http\Controllers\PackageController::class);

