<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'Auth\AuthController@getCustomLogin');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/* Appointment Routes */
Route::get('languages/set-languages/{id}','HomeController@setLanguages');
Route::resource('languages','LanguageController');
/* close Appointment Routes */


/* START CRUD */

Route::resource('modules','ModuleController');
Route::resource('keywords','KeywordController');
Route::resource('countries','CountryController');
Route::resource('keyword-translations','KeywordTranslationController');
Route::resource('configs','ConfigController');
Route::resource('groups','GroupController');
Route::resource('email-templates','EmailTemplateController');
Route::resource('breadcrumbs','BreadcrumbController');
Route::resource('activity-types','ActivityTypeController');
Route::resource('activity-templates','ActivityTemplateController');
Route::resource('product-specifications','Specification\ProductSpecification');
Route::resource('general-specifications','Specification\GeneralSpecification');
Route::resource('upload-logs','UploadLogsController');
Route::resource('download-logs','DownloadLogsController');


Route::get('developer-configurations/{id}/delete-dev-config','DeveloperConfigurationController@deleteDevConfig');
Route::post('developer-configurations/bulk-update','DeveloperConfigurationController@bulkUpdate');
Route::resource('developer-configurations','DeveloperConfigurationController');

Route::get('item-configurations/{id}/delete-item-config','ItemConfigurationController@deleteItemConfig');
Route::post('item-configurations/bulk-update','ItemConfigurationController@bulkUpdate');
Route::resource('item-configurations','ItemConfigurationController');

/* END CRUD */


Route::get('permissions/all','PermissionController@viewAll');
Route::get('permissions/update','PermissionController@updatePermissionByGroup');
Route::get('permissions/users','PermissionController@viewUserPermissions');
Route::get('permissions/users/{id}','PermissionController@updateUserPermissions');
Route::get('permissions/users-update','PermissionController@updateUserPermissionsPost');
Route::resource('permissions','PermissionController');

Route::resource('group-permissions','GroupPermissionController');
Route::resource('user-permissions','UserPermissionController');
Route::resource('words-dictionary','WordsDictionary');
Route::resource('users','UserController');
Route::resource('client','ClientController');


/* FPRWD START */

Route::get('product/ref/{id}','Fprwd\ReferenceController@ref');
Route::get('product/pdn/{id}','Fprwd\PdnController@pdn');
Route::get('product/writer/{id}','Fprwd\WriterController@writer');
Route::get('product/delivery/{id}','Fprwd\DeliveryController@delivery');

Route::get('product/refupload/{id}','Fprwd\ReferenceController@refUpload');
Route::post('product/refupload/{id}','Fprwd\ReferenceController@refUpload');
Route::get('refupload/{id}/after','Fprwd\ReferenceController@refAfterUpload');

Route::post('product/pdnupload/{id}','Fprwd\PdnController@pdnUpload');
Route::get('pdnupload/{id}/after','Fprwd\ReferenceController@pdnAfterUpload');

Route::post('product/deliveryupload/{id}','Fprwd\DeliveryController@deliveryUpload');

Route::post('product/refuploadverify/{id}','Fprwd\ReferenceController@refUploadVerify');
Route::post('product/pdnuploadverify/{id}','Fprwd\PdnController@pdnUploadVerify');
Route::post('product/deliveryuploadverify/{id}','Fprwd\DeliveryController@deliveryUploadVerify');

Route::get('product/ftp/{id}','Fprwd\FtpController@viewReference');
Route::get('product/ftp/{id}/images','Fprwd\FtpController@viewReferenceImage');
Route::get('product/ftp/{id}/picture/','Fprwd\FtpController@ftpImageView');

//Route::resource('prd/approveupload','ProductController@approveUpload');
Route::resource('prd/approveupload','ProductController@approve');


/* CLOSE FPRWD END */


Route::post('product/boConfigs/{id}','ProductController@boConfigs');
Route::post('product/clientConfigs/{id}','ProductController@clientConfigs');
Route::post('product/configs/{id}','ProductController@configs');

Route::resource('product','ProductController');
Route::resource('items','ItemController');



/* Explicit Resources */
//Users
Route::get('accessDenied','UserController@accessDenied');
Route::get('profile/{id}','UserController@profile');
Route::get('editProfile','UserController@editProfile');
Route::post('doEdit/{id}','UserController@doEdit');

Route::get('test','ErrandController@test');
Route::post('userImage','ErrandController@userImageUpload');
Route::post('testPost','ErrandController@testPost');
Route::post('client/addProductHelper/{id}','ErrandController@newProductLine');
Route::post('client/addMailingListHelper/{id}','ErrandController@addMailingListHelper');

/* Appointment Routes */
Route::get('appointments/pdt-ajax-call','AppointmentController@productAjaxCall');
Route::get('appointments/epincharge-ajax-call','AppointmentController@epinchargeAjaxCall');
Route::get('appointments/clientincharge-ajax-call','AppointmentController@clientinchargeAjaxCall');
Route::resource('appointments','AppointmentController');
/* close Appointment Routes */

/* Mail Function */
Route::get('mailbox/{id}/message/{bool}','EMailerController@message');
Route::get('mailbox/{id}/reply','EMailerController@replyMessage');
Route::get('mailbox/{id}/delete','EMailerController@deleteMessage');
Route::get('mailbox/{id}/save','EMailerController@draftMessage');
Route::resource('mailbox','EMailerController');
/* Close Mail Function */

/* Activity */
Route::resource('activities','ActivitiesController');
/* Close Activity */

Route::get('download/{id}','DownloadController@download');
Route::get('download/{id}/s','DownloadController@simpleDownload');

/* CLIENT CONTROLLERS START
* Add All Routes related to the Client Here
* All Custome Links for client Listed Here
*/

//Lahalle
Route::get('client/lahalle/shoe/{id}','Client\LahalleController@shoeGen'); //Lahalle Sheo Generation
Route::get('client/lahalle/cloth/{id}','Client\LahalleController@clothGen'); //Lahalle Sheo Generation

Route::get('client/korben/ref/{id}/{id2}','Client\KorbenController@ref'); //Korben reference Uplaod


/* CLIENT CONTROLLERS END */


/* Url to Export data to DB */
Route::get('test/importR/{id}','ErrandController@refImport');
Route::get('test/importW/{id}','ErrandController@writerImport');
