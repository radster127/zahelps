<?php

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

Route::get('/welcome', function () {
    return view('member.layout');
});
Route::get('/email',function(){
   /* Mail::send('', $data, function($message) {
        $message->from('radster127@gmail.com', 'Learning Laravel');
        $message->to('radster127@gmail.com')->subject('Transaction Confirmation');
      });   */


    Mail::send('',$data, function($message){
      $message->to('radster127@gmail.com','To Radz');
      $message->subject('You can use HTML');
                
      $message->from('radster127@gmail.com','Radz');
    });
});


/* * ********************************************************* */
/*                      Admin Routes                        */
/* * ********************************************************* */

Route::get('/admin', 'admin\LoginController@login');
Route::get('/admin/login', 'admin\LoginController@login');
Route::post('/admin/login', 'admin\LoginController@postLogin');

Route::get('/admin/forget-password', 'admin\LoginController@forgetPassword');
Route::post('/admin/forget-password', 'admin\LoginController@postForgetPassword');


Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {

  Route::get('/admin/profile', 'admin\UserController@profile');
  Route::post('/admin/update-profile', 'admin\UserController@updateProfile');
  Route::get('/admin/change-password', 'admin\UserController@changePassword');
  Route::post('/admin/change-password', 'admin\UserController@updatePassword');
  Route::get('/admin/logout', 'admin\LoginController@getLogout');
  //Route::get('/admin/logout', 'Auth\AuthController@logout');

  Route::get('/admin/dashboard', 'admin\DashboardController@index');

  Route::get('/admin/settings/web', 'admin\SettingController@webSettings')->name('settings-web');
  Route::get('/admin/settings/get-help', 'admin\SettingController@ghSettings')->name('settings-get-help');
  Route::get('/admin/settings/provide-help', 'admin\SettingController@phSettings')->name('settings-provide-help');
  Route::get('/admin/settings/profit', 'admin\SettingController@profitSettings')->name('settings-profit');
  Route::post('/admin/settings', 'admin\SettingController@update');


  Route::post('/admin/gh/freeze/{id}', 'admin\GHController@freeze')->name('gh-freeze');
  Route::post('/admin/ph/freeze/{id}', 'admin\PHController@freeze')->name('ph-freeze');

  Route::get('/admin/gh/pending/{gh_id}', 'admin\GHController@pendingPHList');
  Route::get('/admin/gh/make-pair/{gh_id}/{ph_id}', 'admin\GHController@makeManuallPair')->name('admin-make-manual-pair');
  Route::get('/admin/gh/pending', 'admin\GHController@pending');
  
  Route::resource('/admin/pair', 'admin\PairController');
  Route::resource('/admin/gh', 'admin\GHController');
  Route::resource('/admin/ph', 'admin\PHController');

  Route::resource('/admin/news', 'admin\NewsController');
  Route::resource('/admin/pages', 'admin\PageController');
  Route::resource('/admin/faq', 'admin\FaqController');
  Route::resource('/admin/managers', 'admin\ManagerController');
  Route::resource('/admin/letter-of-happiness', 'admin\TestimonialController');


  Route::post('/admin/users/change-password', 'admin\UserController@changeUserPassword');

  Route::get('/admin/users/{users}/suspend', 'admin\UserController@suspend')->name('suspend-user');
  Route::get('/admin/users/{users}/unsuspend', 'admin\UserController@unsuspend')->name('unsuspend-user');
  Route::get('/admin/users/suspended-users', 'admin\UserController@suspendedUsers');

  Route::get('/admin/users/directors', 'admin\UserController@directors')->name('director-list');
  Route::get('/admin/users/remove-director/{user_id}/{manager_id}', 'admin\UserController@removeDirector')->name('remove-director');
  Route::get('/admin/users/upgrade-members', 'admin\UserController@upgradeMembers');
  Route::get('/admin/users/upgrade-to-director/{user_id}/{manager_id}', 'admin\UserController@upgradeToDirector')->name('upgrade-to-director');

  Route::resource('/admin/users', 'admin\UserController');


  Route::get('/admin/inbox', 'admin\MessageController@inbox');
  Route::get('/admin/outbox', 'admin\MessageController@outbox');
  Route::get('/admin/message-detail/{id}', 'admin\MessageController@detail')->name('admin-message-detail');
  Route::get('/admin/compose-message', 'admin\MessageController@compose');
  Route::post('/admin/send-message', 'admin\MessageController@sendMessage');

  Route::get('/admin/broadcast', 'admin\MessageController@broadcast');
  Route::post('/admin/send-broadcast', 'admin\MessageController@sendBroadcast');
});



/* * ********************************************************* */
/*                     landing page Routes                         */
/* * ********************************************************* */

Route::get('/',function(){
    return view('landing.index');
});
Route::get('/home',function(){
    return view('landing.index');
});
Route::get('/aboutus',function(){
    return view('landing.aboutus');
});
Route::get('/plan',function(){
    return view('landing.plan');
});
Route::get('/bonus',function(){
    return view('landing.bonus');
});
Route::get('/contactus',function(){
    return view('landing.contactus');
});
Route::get('/login',function(){
    return view('landing.contactus');
});
Route::get('/register',function(){
    return view('member.register');
});




/* * ********************************************************* */
/*                      Members Routes                         */
/* * ********************************************************* */
//Route::get('/', 'member\LoginController@login');

Route::get('/member', 'member\LoginController@login');
Route::get('/member/login', 'member\LoginController@login');
Route::post('/member/login', 'member\LoginController@postLogin');

Route::get('/member/register/{username}', 'member\UserController@referralRegister');
Route::get('/member/register', 'member\UserController@register');
Route::post('/member/register', 'member\UserController@storeRegister');
Route::get('/member/get-users', 'member\UserController@getUsers');

Route::post('/member/forget-password', 'member\LoginController@postForgetPassword');

Route::group(['middleware' => 'App\Http\Middleware\MemberMiddleware'], function() {
  Route::get('/member/logout', 'member\LoginController@getLogout');
  //Route::get('/member/logout', 'Auth\AuthController@logout');

  Route::get('/member/dashboard', 'member\DashboardController@index');
  // User Routes

  Route::get('/member/my-page', 'member\UserController@myPage');

  Route::get('/member/profile', 'member\UserController@profile');
  Route::post('/member/update-profile', 'member\UserController@updateProfile');
  Route::get('/member/change-avatar', 'member\UserController@avatar');
  Route::post('/member/update-avatar', 'member\UserController@updateAvatar');
  Route::get('/member/change-password', 'member\UserController@changePassword');
  Route::post('/member/change-password', 'member\UserController@updatePassword');

  Route::get('/member/my-downline', 'member\UserController@myDownLine');
  Route::get('/member/my-downline/{users}', 'member\UserController@myDownLine')->name('my-downline');

  Route::get('/member/my-levels/{level}', ['uses' => 'member\UserController@levelMembers'])->name('level-members');
  Route::get('/member/my-levels', 'member\UserController@myLevels');

  Route::get('/member/directors', 'member\UserController@directors');

  Route::get('/member/add-member', 'member\UserController@createMember');
  Route::post('/member/store-member', 'member\UserController@storeMember');

  Route::get('/member/letter-of-happiness', 'member\TestimonialController@create');
  Route::post('/member/letter-of-happiness', 'member\TestimonialController@store');

  // PH Routes.
  Route::get('/member/provide-help', 'member\PHController@provideHelp');
  Route::get('/member/email', 'member\PHController@sendEmail');
  Route::post('/member/provide-help', 'member\PHController@storeProvideHelp');
  Route::post('/member/cancel-ph', 'member\PHController@cancelPH');
  Route::get('/member/provide-help/{token}/detail', 'member\PHController@detail')->name('ph-detail');
  Route::get('/member/provide-help-history', 'member\PHController@history');
  Route::post('/member/confirm-ph-payment', 'member\PHController@confirmPayment');


  // GH Routes.
  Route::get('/member/get-help', 'member\GHController@getHelp');
  Route::post('/member/get-help', 'member\GHController@storeGetHelp');
  Route::post('/member/cancel-gh', 'member\GHController@cancelGH');
  Route::get('/member/get-help/{token}/detail', 'member\GHController@detail')->name('gh-detail');
  Route::get('/member/get-help-history', 'member\GHController@history');

  Route::post('/member/approve-pair', 'member\GHController@approvePair')->name('approve-pair');
  Route::post('/member/reject-pair', 'member\GHController@rejectPair')->name('reject-pair');


  Route::get('/member/my-ph-profit-history', 'member\PHController@myPhProfitHistory')->name('my-ph-profit-history');
  Route::get('/member/my-downline-ph-profit-history', 'member\PHController@myDownlinePhProfitHistory')->name('my-downline-ph-profit-history');
  Route::get('/member/director-ph-profit-history', 'member\PHController@directorPhProfitHistory')->name('director-ph-profit-history');

  // Messages Routes
  Route::get('/member/inbox', 'member\MessageController@inbox');
  Route::get('/member/outbox', 'member\MessageController@outbox');
  Route::get('/member/message-detail/{id}', 'member\MessageController@detail')->name('message-detail');
  Route::get('/member/compose-message', 'member\MessageController@compose');
  Route::post('/member/send-message', 'member\MessageController@sendMessage');
  Route::post('/member/send-pair-message', 'member\MessageController@sendPairMessage');
});



/* * ********************************************************* */
/*                         Cron Routes                         */
/* * ********************************************************* */


Route::group(['namespace' => 'cron'], function () {
  // Controllers Within The "App\Http\Controllers\cron" Namespace

  Route::get('/cron/calculate-ph-profit', 'PHController@calculatePHProfit');
  Route::get('/cron/make-pair', 'PairController@makePair');
  Route::get('/cron/expire-pair', 'PairController@expirePair');
  Route::get('/cron/auto-approve-pair', 'PairController@autoApprovePair');
  Route::get('/cron/test', 'PairController@test');
  Route::get('/cron/member-log', 'PairController@memberLog');
  Route::get('/cron/remove-duplicate-pair', 'PairController@removeDuplicatePair');
  Route::get('/cron/remove-duplicate-pair2', 'PairController@removeDuplicatePair2');


  // Old data

  Route::get('/cron/data/users', 'DataController@users');
  Route::get('/cron/data/gh', 'DataController@gh');
  Route::get('/cron/data/ph', 'DataController@ph');
  Route::get('/cron/data/pair', 'DataController@pair');
  Route::get('/cron/data/expired-pair', 'DataController@expiredPair');

  Route::get('/cron/data/correct-gh', 'DataController@correctGH');
  Route::get('/cron/data/correct-ph', 'DataController@correctPH');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
