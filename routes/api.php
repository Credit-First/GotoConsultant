<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/chat', 'Api\MessageController@chat');
    Route::post('/chat_channel', 'Api\MessageController@fetchChannel');
    Route::post('/chat_token', 'Api\MessageController@generate');
    Route::post('/check_channel', 'Api\MessageController@checkChannel');
    Route::post('/check_missed_notifications', 'Api\MessageController@checkMissedNotifications');
    Route::post('/fetch_messages', 'Api\MessageController@fetchMessages');
    Route::post('/update_messages', 'Api\MessageController@updateMessages');

    Route::post('/add_missed_notification', 'Api\MessageController@addMissedNotification');

    Route::post('/call', 'Api\VoiceController@initiateCall');
    Route::post('/call_token', 'Api\VoiceController@generate');
    Route::post('/new_token', 'Api\VoiceController@newToken');
    Route::post('/call_status', 'Api\VoiceController@callStatus');

    Route::post('/video_token', 'Api\VideoController@joinRoom');
    Route::post('/create_room', 'Api\VideoController@createRoom');

    Route::post('/manage_status', 'Api\ApiController@manageStatus');
    Route::post('/manage_transaction', 'Api\ApiController@manageTransaction');
    Route::post('/submit_review', 'Api\ApiController@manageReview');
    Route::get('/get-universities', 'Api\ApiController@getUniversities');
    Route::get('/delete-plan-session/{id}', 'Api\ApiController@deletePlanSession');

    Route::post('/member_image_upload', 'Api\ApiController@memberImageUpload');
    Route::post('/member_image_delete', 'Api\ApiController@memberImageDelete');
    Route::post('/update_member_profile', 'Api\ApiController@updateMemberProfile');
    Route::post('/update_member_setting', 'Api\ApiController@updateMemberSetting');
    Route::post('/consultant_doc_upload', 'Api\ApiController@consultantDoc');
    Route::post('/get_reviews', 'Api\ApiController@get_reviews');
    Route::post('/add_request', 'Api\ApiController@addRequest');
    Route::post('/find_new_registered_user', 'Api\ApiController@find_new_registered_user');

    Route::post('/create_consultant', 'Api\ApiController@createConsultant');
    Route::post('/update_consultant', 'Api\ApiController@updateConsultant');

    Route::post('/create_customer', 'Api\ApiController@createCustomer');
    Route::post('/update_customer', 'Api\ApiController@updateCustomer');

    Route::post('/create_category', 'Api\ApiController@createCategory');
    Route::post('/update_category', 'Api\ApiController@updateCategory');

    Route::post('/update_setting', 'Api\ApiController@updateSetting');
    Route::post('/update_page', 'Api\ApiController@updatePage');
    Route::post('/create_page', 'Api\ApiController@createPage');

    Route::post('/admin_home_help_image_upload', 'Api\ApiController@homeHelpImageUpload');
    Route::post('/admin_home_benefit_image_upload', 'Api\ApiController@homeBenefitImageUpload');
    Route::post('/admin_home_review_image_upload', 'Api\ApiController@homeReviewImageUpload');
    Route::post('/admin_become_consultant_platform_image_upload', 'Api\ApiController@becomeConsultantPlatformImageUpload');
    Route::post('/admin_banner_image_upload', 'Api\ApiController@adminBannerImageUpload');

    Route::get('/dashboard/get', 'Api\ApiController@memberDashboardGet');
    // Payment Routes
    Route::post('/stripe_charge', 'Api\ApiController@stripeCharge');
    Route::post('/charge_balance', 'Api\ApiController@chargeBalance');

    Route::post('/update_booking_status', 'Api\ApiController@updateBookingStatus');

});

