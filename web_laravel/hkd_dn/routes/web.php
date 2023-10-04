<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Route::get('/testRandomPass', function () {
// 	$all = DB::table("users")->get();
// 	foreach ($all as $aUser) {
// 		if(isset($aUser->province)){
// 			$newPass = Str::random(10);
// 			DB::table("users")->where("id", $aUser->id)->update([
// 				"password" => Hash::make($newPass),
// 				"temp" => $newPass
// 			]);
// 		}
// 	}
// });

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


	Route::get('/dashboard',[
		'as'=> 'home',
		'uses'=> '\App\Http\Controllers\Dashboard\DashboardController@dashboard',
	])->middleware('auth');


	Route::get('/',[
		'as'=> 'index',
		'uses'=> '\App\Http\Controllers\HomeController@index',
	]);

	Route::get('/smes',[
		'as'=> 'dashboard-smes',
		'uses'=> '\App\Http\Controllers\HomeController@smes',
	])->middleware('auth');
	Route::get('/hkd',[
		'as'=> 'dashboard-hkd',
		'uses'=> '\App\Http\Controllers\HomeController@hkd',
	])->middleware('auth');
	Route::get('/vnptthuebao',[
		'as'=> 'dashboard-vnptthuebao',
		'uses'=> '\App\Http\Controllers\HomeController@vnptthuebao',
	])->middleware('auth');

	Route::get('/dashboard/statistic',[
		'as'=> 'dashboard-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@statistic',
	])->middleware('auth');

	Route::get('/dashboard/statistic-sme',[
		'as'=> 'dashboard-statistic-sme',
		'uses'=> '\App\Http\Controllers\HomeController@statisticSME',
	])->middleware('auth');

	Route::get('/dashboard/statistic-vnptthuebao',[
		'as'=> 'dashboard-statistic-vnptthuebao',
		'uses'=> '\App\Http\Controllers\HomeController@statisticVnptThueBao',
	])->middleware('auth');


	Route::get('/dashboard/ca-service',[
		'as'=> 'dashboard-ca-service',
		'uses'=> '\App\Http\Controllers\HomeController@dashboardCaService',
	])->middleware('auth');

	Route::get('/api/dashboard/ca-service',[
		'as'=> 'api-dashboard-ca-service',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaService',
	])->middleware('auth');
	
	Route::get('/api/dashboard/ca-service-export',[
		'as'=> 'api-dashboard-ca-service-export',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaServiceExport',
	])->middleware('auth');


	
	Route::get('/api/dashboard/ca-ttkds',[
		'as'=> 'api-dashboard-ca-ttkds',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaTTKDs',
	])->middleware('auth');
	Route::get('/api/dashboard/ca-packages',[
		'as'=> 'api-dashboard-ca-packages',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaPackages',
	])->middleware('auth');
	Route::get('/api/dashboard/ca-types',[
		'as'=> 'api-dashboard-ca-types',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaTypes',
	])->middleware('auth');
	Route::get('/api/dashboard/ca-stations',[
		'as'=> 'api-dashboard-ca-stations',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaStations',
	])->middleware('auth');
	Route::get('/api/dashboard/ca-customertypes',[
		'as'=> 'api-dashboard-ca-customertypes',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaCustomerTypes',
	])->middleware('auth');

	Route::get('/dashboard/ca-revenue',[
		'as'=> 'dashboard-ca-revenue',
		'uses'=> '\App\Http\Controllers\HomeController@dashboardCaRevenue',
	])->middleware('auth');

	Route::get('/api/dashboard/ca-revenue',[
		'as'=> 'api-dashboard-ca-revenue',
		'uses'=> '\App\Http\Controllers\HomeController@apiDashboardCaRevenue',
	])->middleware('auth');
	
	Route::get('/api/statistic-vnptthuebao',[
		'as'=> 'api-statistic-vnptthuebao',
		'uses'=> '\App\Http\Controllers\HomeController@statisticVnptThueBaoGrid',
	])->middleware('auth');

	Route::get('/api/statistic-vnptthuebao-list',[
		'as'=> 'api-statistic-vnptthuebao-list',
		'uses'=> '\App\Http\Controllers\HomeController@statisticVnptThueBaoList',
	])->middleware('auth');
	
	Route::get('/api/statistic-vnptthuebao-vnedu',[
		'as'=> 'api-statistic-vnptthuebao',
		'uses'=> '\App\Http\Controllers\HomeController@statisticVnptThueBaoVnEduGrid',
	])->middleware('auth');

	Route::get('/api/statistic-vnptthuebao-vnedu-list',[
		'as'=> 'api-statistic-vnptthuebao-list',
		'uses'=> '\App\Http\Controllers\HomeController@statisticVnptThueBaoVnEduList',
	])->middleware('auth');
	
	Route::get('/api/statistic-vnptthuebao-igate',[
		'as'=> 'api-statistic-vnptthuebao',
		'uses'=> '\App\Http\Controllers\HomeController@statisticVnptThueBaoIgateGrid',
	])->middleware('auth');

	Route::get('/api/statistic-vnptthuebao-igate-list',[
		'as'=> 'api-statistic-vnptthuebao-list',
		'uses'=> '\App\Http\Controllers\HomeController@statisticVnptThueBaoIgateList',
	])->middleware('auth');

	Route::get('/dashboard/statistic-newclients',[
		'as'=> 'dashboard-statistic-newclients',
		'uses'=> '\App\Http\Controllers\HomeController@statisticNewClients',
	])->middleware('auth');
	
	Route::get('/dashboard/detail-smes',[
		'as'=> 'dashboard-detail-smes',
		'uses'=> '\App\Http\Controllers\HomeController@detailSmes',
	])->middleware('auth');

	Route::get('/api/user-smes',[
		'as'=> 'api-user-smes',
		'uses'=> '\App\Http\Controllers\HomeController@userSmes',
	])->middleware('auth');
	
	Route::get('/dashboard/detail-hkd',[
		'as'=> 'dashboard-detail-hkd',
		'uses'=> '\App\Http\Controllers\HomeController@detailHKD',
	])->middleware('auth');

	Route::get('/api/detail-hkd/statistic',[
		'as'=> 'dashboard-detail-hkd-statistic',
		'uses'=> '\App\Http\Controllers\HomeController@detailHKDStatistic',
	])->middleware('auth');

	Route::get('/api/user-vnptthuebao',[
		'as'=> 'api-user-vnptthuebao',
		'uses'=> '\App\Http\Controllers\HomeController@userVnptThueBao',
	])->middleware('auth');
	Route::get('/api/user-hkd',[
		'as'=> 'api-user-hkd',
		'uses'=> '\App\Http\Controllers\HomeController@userHKD',
	])->middleware('auth');
	Route::get('/api/user-hkd-history',[
		'as'=> 'api-user-hkd-history',
		'uses'=> '\App\Http\Controllers\HomeController@userHKDHistory',
	])->middleware('auth');
	Route::get('/api/user-hkd-history-tax-all',[
		'as'=> 'api-user-hkd-history-tax-all',
		'uses'=> '\App\Http\Controllers\HomeController@userHKDHistoryTaxAll',
	])->middleware('auth');
	Route::get('/api/user-hkd-history-tax-change',[
		'as'=> 'api-user-hkd-history-tax-change',
		'uses'=> '\App\Http\Controllers\HomeController@userHKDHistoryTaxChange',
	])->middleware('auth');
	Route::get('/api/user-hkd-history-tax-gtgt',[
		'as'=> 'api-user-hkd-history-tax-gtgt',
		'uses'=> '\App\Http\Controllers\HomeController@userHKDHistoryTaxGtgt',
	])->middleware('auth');
	Route::get('/api/user-hkd-history-tax-off',[
		'as'=> 'api-user-hkd-history-tax-off',
		'uses'=> '\App\Http\Controllers\HomeController@userHKDHistoryTaxOff',
	])->middleware('auth');
  
	Route::get('/api/statistic-gdt',[
		'as'=> 'api-statistic-gdt',
		'uses'=> '\App\Http\Controllers\HomeController@statisticGdt',
	])->middleware('auth');
	
	Route::get('/api/statistic-gdt-list',[
		'as'=> 'api-statistic-gdt-list',
		'uses'=> '\App\Http\Controllers\HomeController@statisticGdtList',
	])->middleware('auth');
  
	Route::get('/api/statistic-smes',[
		'as'=> 'api-statistic-smes',
		'uses'=> '\App\Http\Controllers\HomeController@statisticSMEs',
	])->middleware('auth');
	
	Route::get('/api/statistic-smes-list',[
		'as'=> 'api-statistic-smes-list',
		'uses'=> '\App\Http\Controllers\HomeController@statisticSMESList',
	])->middleware('auth');
	
	
	Route::get('/export',[
		'as'=> 'export',
		'uses'=> '\App\Http\Controllers\HomeController@export',
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

