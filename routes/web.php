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
Route::middleware('web')->group(function () {
    Route::middleware('checkLocale')->group(function () {
        Route::get('/', function () {
            $lang = app()->getLocale();
            if ($lang == 'en') {
                return redirect('/');
            } else {
                return redirect('/no');
            }
        });
        Route::get('/', 'Client\PagesController@index');
        Route::get('/features', 'Client\PagesController@features');
        Route::get('/become-consultant', 'Client\PagesController@become_consultant');
        Route::get('/about', 'Client\PagesController@about_us');
        Route::get('/privacy', 'Client\PagesController@privacy');
        Route::get('/terms-customer', 'Client\PagesController@terms_customer');
        Route::get('/terms-consultant', 'Client\PagesController@terms_provider');
        Route::get('/category/{type}', 'Client\PagesController@category_info');
        Route::get('/category-search', 'Client\PagesController@categorySearch');

        Route::get('/no', 'Client\PagesController@index');
        Route::get('/no/funksjoner', 'Client\PagesController@features');
        Route::get('/no/bli-konsulent', 'Client\PagesController@become_consultant');
        Route::get('/no/om-oss', 'Client\PagesController@about_us');
        Route::get('/no/personvern', 'Client\PagesController@privacy');
        Route::get('/no/vilkar-kunde', 'Client\PagesController@terms_customer');
        Route::get('/no/vilkar-konsulent', 'Client\PagesController@terms_provider');
        Route::get('/no/kategori/{type}', 'Client\PagesController@category_info');
        Route::get('/no/kategori-sok', 'Client\PagesController@categorySearch');

        Route::post("/site-lang", 'Client\PagesController@updateLang');
        //authentication routers
        Route::get('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
        Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);

        Route::get('/no/registrer', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
        Route::get('/no/logg-inn', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);

        Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
        Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        //admin routers
        Route::get('/admin-dashboard', 'Server\PagesController@adminDashboard');
        Route::get('/dashboard-search', 'Server\PagesController@adminDashboardSearch');
        Route::get('/pages', 'Server\PagesController@pages');
        Route::get('/create-page', 'Server\PagesController@createPage');
        Route::get('/edit-page/{id}', 'Server\PagesController@editPage');
        Route::get('/customers', 'Server\PagesController@customers');
        Route::get('/create-customer', 'Server\PagesController@createCustomer');
        Route::get('/edit-customer/{id}', 'Server\PagesController@editCustomer');
        Route::get('/consultants', 'Server\PagesController@consultants');
        Route::get('/create-consultant', 'Server\PagesController@createConsultant');
        Route::get('/edit-consultant/{id}', 'Server\PagesController@editConsultant');
        Route::get('/categories', 'Server\PagesController@categories');
        Route::get('/create-category', 'Server\PagesController@createCategory');
        Route::get('/edit-category/{id}', 'Server\PagesController@editCategory');
        Route::get('/settings', 'Server\PagesController@settting');
        Route::get('/admin-transaction', 'Server\PagesController@adminTransaction');
        Route::get('/admin-transaction-search', 'Server\PagesController@adminTransactionSearch');
        Route::post('/admin-delete-transaction/{transaction_id}', 'Server\PagesController@adminDeleteTransaction');


        Route::get('/admin-payout', 'Server\PagesController@adminPayout');
        Route::get('/admin-payout-search', 'Server\PagesController@adminPayoutSearch');

        Route::get('/admin-invoices', 'Server\PagesController@adminInvoices');
        Route::get('/admin-invoices-search', 'Server\PagesController@adminInvoicesSearch');

        Route::post('/adminSetTransactionStatusPayed', 'Server\PagesController@adminSetTransactionStatusPayed');
        Route::get('admin-pay-consultant-invoice/{invoice_id}', 'Server\AdminStripeController@payConsultantInvoice')->name('admin.pay-consultant-invoice');
        Route::get('admin-consultant-stripe/{id}', [Server\AdminStripeController::class, 'redirectToStripe'])->name('admin.consultant.redirect.stripe');
        Route::get('admin-consultant-connect/{token}', [Server\AdminStripeController::class, 'saveStripeAccount'])->name('admin.consultant.save.stripe');


        /* 					'refresh_url' => route('admin.consultant.redirect.stripe', ['id' => $consultantUser->id]),
					'return_url'  => route('admin.consultant.save.stripe', ['token' => $stripeToken->token]), */
        // Route::get('admin-pay-consultant-invoice{invoice_id}', 'Server\PagesController@payConsultantInvoice')->name('admin.pay-consultant-invoice');


        Route::get('/no/admin-dashbord', 'Server\PagesController@adminDashboard');
        Route::get('/no/dashboard-sok', 'Server\PagesController@adminDashboardSearch');
        Route::get('/no/sider', 'Server\PagesController@pages');
        Route::get('/no/opprett-side', 'Server\PagesController@createPage');
        Route::get('/no/rediger-side/{id}', 'Server\PagesController@editPage');
        Route::get('/no/kunder', 'Server\PagesController@customers');
        Route::get('/no/opprett-kunde', 'Server\PagesController@createCustomer');
        Route::get('/no/rediger-kunde/{id}', 'Server\PagesController@editCustomer');
        Route::get('/no/konsulenter', 'Server\PagesController@consultants');
        Route::get('/no/opprett-konsulent', 'Server\PagesController@createConsultant');
        Route::get('/no/rediger-konsulent/{id}', 'Server\PagesController@editConsultant');
        Route::get('/no/kategorier', 'Server\PagesController@categories');
        Route::get('/no/opprett-kategori', 'Server\PagesController@createCategory');
        Route::get('/no/rediger-kategori/{id}', 'Server\PagesController@editCategory');
        Route::get('/no/innstillinger', 'Server\PagesController@settting');
        Route::get('/no/admin-transaksjoner', 'Server\PagesController@adminTransaction');
        Route::get('/no/admin-transaksjoner-sok', 'Server\PagesController@adminTransactionSearch');

        //member routers
        Route::get('/find-consultant', 'Client\PagesController@findConsultant')->name('find-consultant');
        Route::get('/find-consultant-search', 'Client\PagesController@findConsultantSearch');
        Route::get('/dashboard', 'Client\PagesController@dashboard');
        Route::get('/sessions', 'Client\PagesController@session');
        Route::get('/sessions/{id}', 'Client\PagesController@singleSession');

        // Plan
        Route::get('/plan', 'Client\PagesController@plans');
        Route::post('/plan', 'Client\PagesController@savePlan')->name('plan.create');
        Route::get('/plan/{id}', 'Client\PagesController@deletePlan')->name('plan.delete');
        Route::get('/no/planer', 'Client\PagesController@plans');

        // Plan session
        Route::post('/plan/session/{id}', 'Client\PagesController@savePlanSession')->name('plan.session.create');

        // Update available hours
        Route::post('/available-hours', 'Client\PagesController@updateAvailableHours')->name('availablehours');

        // booking
        Route::post('/booking', 'Client\PagesController@booking')->name('booking');
        Route::get('/booking/payment/{id}', 'Client\PagesController@bookingPayment')->name('booking.payment');

        // Calendar
        Route::get('/calendar', 'Client\PagesController@calendar');
        Route::get('/no/kalender', 'Client\PagesController@calendar');

        Route::get('/wallet', 'Client\PagesController@wallet');
        Route::get('/wallet-search', 'Client\PagesController@walletSearch');
        Route::get('/transactions ', 'Client\PagesController@transactions');
        Route::get('/transaction-search ', 'Client\PagesController@transactionSearch');
        Route::get('/my-payouts', 'Client\PagesController@myPayouts');
        Route::get('/my-payouts-search', 'Client\PagesController@myPayoutsSearch');
        Route::get('/my-payout-into-pdf/{payout_id}', [ 'uses' => 'Client\PagesController@my_payout_into_pdf' ] );
        Route::post('generate-payment-pdf-by-content', array(
            'as'      => 'generate-payment-pdf-by-content',
            'uses'    => 'Client\PagesController@generate_payment_receipt_pdf_by_content'
        )) ;

        Route::get('get_invoice_data/{invoice_id}', array(
            'as'      => 'get_invoice_data',
            'uses'    => 'Client\PagesController@get_invoice_data'
        )) ;


        // http://127.0.0.1:8000/my-payout-into-pd/1
        Route::get('/profile', 'Client\PagesController@profile');
        Route::get('/profile/{id}', 'Client\PagesController@singleProfile');
        Route::get('/member-settings', 'Client\PagesController@settings');
        Route::get('/member/privacy', 'Client\PagesController@memberPrivacy');
        Route::get('/member/terms-customer', 'Client\PagesController@memberTermsCustomer');
        Route::get('/member/terms-consultant', 'Client\PagesController@memberTermsProvider');

        Route::get('/no/finn-konsulent', 'Client\PagesController@findConsultant')->name('find-consultant');
        Route::get('/no/finn-konsulent-sok', 'Client\PagesController@findConsultantSearch');
        Route::get('/no/oversikt', 'Client\PagesController@dashboard');
        Route::get('/no/moter', 'Client\PagesController@session');
        Route::get('/no/moter/{id}', 'Client\PagesController@singleSession');
        Route::get('/no/lommebok', 'Client\PagesController@wallet');
        Route::get('/no/lommebok-sok', 'Client\PagesController@walletSearch');
        Route::get('/no/transaksjoner ', 'Client\PagesController@transactions');
        Route::get('/no/transaksjoner-sok ', 'Client\PagesController@transactionSearch');
        Route::get('/no/profil', 'Client\PagesController@profile');
        Route::get('/no/profil/{id}', 'Client\PagesController@singleProfile');
        Route::get('/no/kontoinnstillinger', 'Client\PagesController@settings');
        Route::get('/no/medlem/personvern', 'Client\PagesController@memberPrivacy');
        Route::get('/no/medlem/vilkar-kunde', 'Client\PagesController@memberTermsCustomer');
        Route::get('/no/medlem/vilkar-konsulent', 'Client\PagesController@memberTermsProvider');

        Route::post('/klarna_checkout', 'Client\PagesController@klarna_checkout');
        Route::get('/klarna_confirmation', 'Client\PagesController@klarna_confirmation');
        Route::get('/password/forgot', 'Client\PagesController@forgotPassword');
        Route::get('/no/passord/glemte', 'Client\PagesController@forgotPassword');
        Route::get('/reset-password/{code}', 'Client\PagesController@resetPassword')->name('reset-password');
        Route::get('/account-activate/{code}', 'Client\PagesController@emailVerification')->name('account-activate');

        Route::post('/send_reset_password_request', 'Client\PagesController@send_reset_password_request');

        Route::post('/memberCreateInvoice', 'Client\PagesController@memberCreateInvoice');
        //API routes
        Route::post('/api/klarna_checkout', 'Api\Klarna@createCheckout');
        Route::get('/api/klarna/push/{checkout_uri}', 'Api\Klarna@push');

        Route::post('/api/become-consultant', 'Client\PagesController@becomeConsultant');
        Route::post('/api/reset-password', 'Client\PagesController@reset_password');

        Route::post('/support/call','Api\VoiceController@voiceHook');
    });
});

Route::get('/test', 'Client\PagesController@test');
