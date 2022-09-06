<?php

use App\Models\Rental_category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Home_controller;
use App\Http\Controllers\Admin\Tenant_controller;
use App\Http\Controllers\Front\SignUp_controller;
use App\Http\Controllers\Admin\Location_controller;
use App\Http\Controllers\Admin\Property_controller;
use App\Http\Controllers\Admin\Roomnames_controller;
use App\Http\Controllers\Admin\Userroles_controller;
use App\Http\Controllers\Admin\Rentaltags_controller;
use App\Http\Controllers\Admin\Manageusers_controller;
use App\Http\Controllers\Front\Userprofile_controller;
use App\Http\Controllers\Admin\Rentalhouses_controller;
use App\Http\Controllers\Admin\Activerentals_controller;
use App\Http\Controllers\Front\Mpesapayments_controller;
use App\Http\Controllers\Admin\Admindashboard_controller;
use App\Http\Controllers\Admin\Rentalcategory_controller;
use App\Http\Controllers\Front\Rentalslisting_controller;
use App\Http\Controllers\Front\Propertieslisting_controller;
use App\Http\Controllers\Admin\Inactiverentals_controller;
use App\Http\Controllers\Admin\Propertycategory_controller;
use App\Http\Controllers\Admin\Rentalextraimages_controller;
use App\Models\Propertycategory;

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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

                // home controllers
Route::get('/', [Home_controller::class, 'index'])->name('home.index');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// front page routes
// Route::get('/', [Home_controller::class,'index'])->name('index');

// all pages for the user panel
Route::get('/contact_us', [Home_controller::class,'contactus'])->name('contact.us');

Route::post('contact_admin', [Home_controller::class,'contactadmin'])->name('contact.admin');

// Login and Register page for the users
Route::get('/login_register', [SignUp_controller::class,'login_register'])->name('login_register');

// login and register route for the user
Route::post('login',[SignUp_controller::class,'loginuser'])->name('loginuser');

Route::post('register',[SignUp_controller::class,'registeruser'])->name('registeruser');

Route::post('check_email',[SignUp_Controller::class,'check_email'])->name('check_email');

Route::post('logout',[SignUp_controller::class,'logoutuser'])->name('logoutuser');

Route::post('forgotpassword',[SignUp_controller::class,'forgotpassword'])->name('forgotpassword');

// Register modal
Route::get('/getroomsforahouse', [Home_controller::class,'getroomsforahouse'])->name('getrooms.house');

// newsletter subscriptions
Route::post('subscribe',[Home_controller::class,'newslettersubscribe'])->name('newsletter.subscribe');

// user profile page 
Route::group(['middleware'=>['auth']],function(){
    
    // manage user account's
    Route::get('/deactivateaccount',[Userprofile_controller::class,'deactivateaccount'])->name('deactivate.account');

    Route::get('myaccount/{id}', [Userprofile_controller::class, 'myaccount'])->name('myaccount.index');

    Route::post('updateprofileimg',[Userprofile_controller::class,'changeprofileimg'])->name('changeprofile.img');

    Route::get('edituseraccount/{id}/edit',[Userprofile_controller::class,'edituseraccount'])->name('edituser.account');

    Route::post('edituserdetails/{id}',[Userprofile_controller::class,'updateuserdetails'])->name('edituser.details');

    Route::post('check_current_password',[Userprofile_controller::class,'checkcurrentpwd'])->name('checkcurrent.password');

    Route::post('updatepassword',[Userprofile_controller::class,'update_password'])->name('updateuser.password');
    

    // pay rent with mpesa
    Route::get('get_tenantmpesapayments',[Mpesapayments_controller::class,'get_tenantmpesapayments'])->name('get_tenant.mpesapayments');

    Route::post('/confirm/mpesa_payment', [Mpesapayments_controller::class,'confirm_transaction'])->name('confirmmpesa.transaction');

    Route::get('viewmpesareceipt/{id}', [Mpesapayments_controller::class,'viewmpesareceipt'])->name('viewpesa.receipt');

    Route::get('downloadmpesareceipt/{id}', [Mpesapayments_controller::class,'generatedownloadreceiptpdf'])->name('downloadreceipt.pdf');
});

// listing page routes
$rentalcatsurls=Rental_category::select('rentalcat_url')->where('status',1)->get()->pluck('rentalcat_url');

foreach($rentalcatsurls as $url)
{
    
    Route::get('/'.$url,[Rentalslisting_controller::class,'rentalcategory_list'])->name('rentalcategory.list');
}

Route::post('autocomplete/search', [Rentalslisting_controller::class,'findhouses'])->name('find.rentalhouses');

Route::get('rentalhse/{rental_slug}/{id}', [Rentalslisting_controller::class,'singlehsedetails'])->name('singlehse.details');

Route::post('sendhserequest',[Rentalslisting_controller::class,'sendhserequest'])->name('send.hserequest');

Route::post('postratingnreview',[Rentalslisting_controller::class,'ratingandreview'])->name('post.ratingreview');

Route::post('getroomprices', [Rentalslisting_controller::class,'getroomprices'])->name('getroom.prices');

// Porperties Routes 
$propertycatsurls=Propertycategory::select('propertycat_url')->where('status',1)->get()->pluck('propertycat_url');

foreach($propertycatsurls as $propertyurl)
{
    
    Route::get('/'.$propertyurl,[Propertieslisting_controller::class,'propertycategory_list'])->name('propertycategory.list');
}

Route::get('property/{property_slug}/{id}', [Propertieslisting_controller::class,'propertydetails'])->name('property.details');

Route::post('sendpropertyrequest',[Propertieslisting_controller::class,'sendpropertyrequest'])->name('send.propertyrequest');

// Admin Routes
Route::group(['prefix'=>'admin','middleware'=>(['auth'])],function(){
    
    // company Admins
    Route::get('assign_userroles',[Manageusers_controller::class,'assignuser_roles'])->name('assignuser.roles');

    Route::get('get_usersrolesassign',[Manageusers_controller::class,'getusersroles_assign'])->name('get_usersroles.assign');

    Route::get('/updateuserrolestatus',[Manageusers_controller::class,'updateuserrolestatus'])->name('updateuser.rolestatus');

    Route::delete('delete_userrole/{id}',[Manageusers_controller::class,'deleteuserrole'])->name('delete.userrole');

    Route::get('getadmin_role/{id}',[Manageusers_controller::class,'getadmin_role'])->name('getadmin_role');

    Route::post('assignadmin_role/{id}',[Manageusers_controller::class,'assign_role'])->name('assign_role');

    Route::get('houserequests',[Manageusers_controller::class,'gethouse_requests'])->name('user.houserequests');

    // all registered users
    Route::get('registered_users',[Manageusers_controller::class,'registered_users'])->name('registered_users');

    Route::get('get_registeredtenants',[Manageusers_controller::class,'getregisteredtenants'])->name('get_registered.tenants');

    Route::middleware('can:adminsnotallowed')->group(function(){

        // tenants management
        Route::get('tenantsstatuses',[Manageusers_controller::class,'tenant_status'])->name('tenants.statuses');

        Route::get('gettenant_status/{id}',[Tenant_controller::class,'gettenant_status'])->name('gettenant.status');

        Route::post('assigntenant_status/{id}',[Tenant_controller::class,'assigntenant_status'])->name('assigntenant.status');

        Route::get('updatetenantstatuses',[Manageusers_controller::class,'updatetenantstatus'])->name('tenants.updatestatus');

        Route::post('addtenantstatus',[Manageusers_controller::class,'addtenantstatus'])->name('addtenant.status');

        Route::get('tenantreviews',[Tenant_controller::class,'tenantreviews'])->name('tenant.reviews');

        Route::get('get_tenantreviews',[Tenant_controller::class,'gettenantreviews'])->name('get_tenant.reviews');

        Route::get('/updatereviewstatus',[Tenant_controller::class,'updatereviewstatus'])->name('updatereview.status');

        // mpesa payments
        Route::get('mpesa_payments',[Admindashboard_controller::class,'mpesapayments'])->name('mpesa.payments');

        Route::get('get_mpesapayments',[Admindashboard_controller::class,'get_mpesapayments'])->name('get_mpesa.payments');

        Route::get('/updatepaymentstatus',[Admindashboard_controller::class,'updatepaymentstatus'])->name('updatepayment.status');

        // manage memos sent to tenants and admins 
        Route::get('/getusersforahouse', [Admindashboard_controller::class,'getuserforahouse'])->name('getusers.house');
        
        Route::get('show_allmemos',[Admindashboard_controller::class,'allmemospage'])->name('show.allmemos');

        Route::get('get_allmemos',[Admindashboard_controller::class,'getallmemos'])->name('get.allmemos');

        Route::get('show_memo/{id}',[Admindashboard_controller::class,'showmemo'])->name('show.memo');

        Route::post('save_memo',[Admindashboard_controller::class,'sendmemotouser'])->name('save.memo');
    });

    // manage roles for the users 
    Route::get('user_roles',[Userroles_controller::class,'alluserroles'])->name('alluser.roles');

    Route::get('get_userroles',[Userroles_controller::class,'get_userroles'])->name('get_user.roles');

    Route::post('addrolename',[Userroles_controller::class,'addrolename'])->name('addrole.name');

    Route::get('userrole/{id}/edit',[Userroles_controller::class,'edituserrole'])->name('userrole.edit');

    Route::post('updateuserrole/{id}',[Userroles_controller::class,'updateuserrole'])->name('userrole.update');

    // Route::delete('delete_userrole/{id}',[Userroles_controller::class,'deleteuserrole'])->name('delete.userrole');

    // show admin dashboard for all the admins
    Route::resource('admindashboard',Admindashboard_controller::class);

    // show  properties to sell
    Route::resource('properties',Admindashboard_controller::class);

    // add rental  to the database
    Route::resource('rentalcategories',Rentalcategory_controller::class);

    Route::post('addacategory',[Rentalcategory_controller::class,'addcategory'])->name('addcategory');

    Route::get('get_housecategories',[Rentalcategory_controller::class,'get_housecategories'])->name('get_housecategories');

    Route::delete('delete_rentalcat/{id}',[Rentalcategory_controller::class,'delete_rentalcategories'])->name('delete_rentalcategories');

            // Rental Houses Management
    // add a new rental space in the db
    Route::get('rentalhouse/add',[Rentalhouses_controller::class,'addrentalhse'])->name('addrentalhse');

    Route::post('rentalhouse/storehse',[Rentalhouses_controller::class,'store'])->name('rental_houses.store');

    Route::get('add_alternateimages/{id}',[Rentalhouses_controller::class,'addalternateimages'])->name('addalternateimages');

    Route::get('edit_alternateimages/{id}',[Rentalhouses_controller::class,'editalternateimages'])->name('editalternateimages');

    Route::post('updaterentaldetails/{id}',[Rentalhouses_controller::class,'updaterentaldetails'])->name('updaterentaldetails');

    Route::post('/delete-rentalhouse',[Rentalhouses_controller::class,'deleterentaldetails'])->name('deleterentaldetails');

    Route::get('/updaterentalhsestatus',[Rentalhouses_controller::class,'updaterentalhsestatus'])->name('updaterentalhse.status');

            // Active Rental houses management
    Route::get('activerentals',[Activerentals_controller::class,'activerentalhses'])->name('activerentalhses');

    Route::get('get_activerentals',[Activerentals_controller::class,'get_activerentals'])->name('get_activerentals');

    Route::get('activerental/{id}/edit',[Activerentals_controller::class,'editactiverental'])->name('activerental.edit');

    
    
            // Inactive Rental houses management
    Route::get('inactiverentals',[Inactiverentals_controller::class,'inactiverentalhses'])->name('inactiverentalhses');

    Route::get('get_inactiverentals',[Inactiverentals_controller::class,'get_inactiverentals'])->name('get_inactiverentals');

    // add a new location in the db
    Route::resource('alllocations',Location_controller::class);

    Route::post('addalocation',[Location_controller::class,'addlocation'])->name('addlocation');

    Route::get('get_locations',[Location_controller::class,'get_locations'])->name('get.locations');

    Route::get('updatelocationstatus',[Location_controller::class,'updatelocationstatus'])->name('updatelocation.status');

    Route::get('location/{id}/edit',[Location_controller::class,'editlocation'])->name('location.edit');

    Route::post('updatelocation/{id}',[Location_controller::class,'updatelocation'])->name('update.location');

    Route::delete('delete_location/{id}',[Location_controller::class,'delete_location'])->name('delete_location');

        // Rental tags management
    Route::get('tagscatmngt',[Rentaltags_controller::class,'tagscatmngt'])->name('tagscatmngt');

    Route::get('get_rentaltags',[Rentaltags_controller::class,'get_rentaltags'])->name('get_rentaltags');

    Route::post('addrentaltag',[Rentaltags_controller::class,'addrentaltag'])->name('addrentaltag');

    Route::get('rentaltag/{id}/edit',[Rentaltags_controller::class,'editrentaltag'])->name('rentaltag.edit');

    Route::post('updaterentaltag/{id}',[Rentaltags_controller::class,'updaterentaltag'])->name('updaterentaltag');

    Route::delete('delete_rentaltag/{id}',[Rentaltags_controller::class,'delete_rentaltag'])->name('delete_rentaltag');

    Route::get('/updaterentaltagstatus',[Rentaltags_controller::class,'updaterentaltagstatus'])->name('updaterentaltagstatus');


        // Rental categories management
    Route::get('get_rentalcats',[Rentalcategory_controller::class,'get_rentalcats'])->name('get_rentalcats');

    Route::post('addrentalcat',[Rentalcategory_controller::class,'addrentalcat'])->name('addrentalcat');

    Route::get('rentalcat/{id}/edit',[Rentalcategory_controller::class,'editrentalcat'])->name('rentalcat.edit');

    Route::post('updaterentalcat/{id}',[Rentalcategory_controller::class,'updaterentalcat'])->name('updaterentalcat');

    Route::delete('delete_rentalcat/{id}',[Rentalcategory_controller::class,'delete_rentalcat'])->name('delete_rentalcat');

    Route::get('/updaterentalcatstatus',[Rentalcategory_controller::class,'updaterentalcatstatus'])->name('updaterentalcatstatus');


   // manage room names for a rental house 
   Route::get('get_roomsizes/{id}',[Roomnames_controller::class,'get_roomsizes'])->name('get_roomsizes');

   Route::post('updatehousesizedetails/{id}',[Roomnames_controller::class,'updatehousesizedetails'])->name('update.housesizedetails');

    Route::get('get_roomnames/{id}',[Roomnames_controller::class,'get_roomnames'])->name('get_roomnames');

    Route::post('addroomname/{id}',[Roomnames_controller::class,'addroomname'])->name('addroomname');

    Route::get('roomname/{id}/edit',[Roomnames_controller::class,'editroomname'])->name('addroomname.edit');

    Route::post('updateroomname/{id}',[Roomnames_controller::class,'updateroomname'])->name('updateroomname');

    Route::get('/updateroomstatus',[Roomnames_controller::class,'updateroomnamestatus'])->name('updateroomname.status');

    Route::delete('delete_roomname/{id}',[Roomnames_controller::class,'delete_roomname'])->name('delete_roomname');


    // alternaterental images for the rental house page

    Route::post('alternateimages/{id}',[Rentalextraimages_controller::class,'alternateimages'])->name('alternateimages');

    Route::get('get_extraimages/{id}',[Rentalextraimages_controller::class,'get_extraimages'])->name('get_extraimages');

    Route::get('/updatextraimagesstatus',[Rentalextraimages_controller::class,'updatextraimagesstatus'])->name('updatextraimages.status');

    Route::delete('delete_xtraimage/{id}',[Rentalextraimages_controller::class,'delete_xtraimage'])->name('delete_xtraimage');

    // add new room sizes for a rental house
    Route::post('roomsizes/{id}',[Rentalextraimages_controller::class,'housesizes'])->name('housesizes.house');

        // properties Management
    Route::get('add_property',[Property_controller::class,'addaproperty'])->name('add.property');

    Route::post('property/store',[Property_controller::class,'store'])->name('property.store');

    Route::get('inactiveproperties',[Property_controller::class,'inactiveproperties'])->name('inactive.properties');

    Route::get('get_inactiveproperties',[Property_controller::class,'get_inactiverentals'])->name('get_inactive.properties');

    Route::get('add_propertyimages/{id}',[Property_controller::class,'addpropertyimages'])->name('addproperty.images');

    Route::post('propertyimages/{id}',[Property_controller::class,'propertyimages'])->name('property.images');

    Route::get('get_propertyimages/{id}',[Property_controller::class,'get_propertyimages'])->name('get_property.images');

    Route::get('/updatepropertyimagesstatus',[Property_controller::class,'updatepropertyimagesstatus'])->name('updatepropertyimages.status');

    // Route::post('delete_xtraimage/{id}',[Property_controller::class,'delete_xtraimage'])->name('delete_xtraimage');

    Route::get('activeproperties',[Property_controller::class,'activeproperties'])->name('active.properties');

    Route::get('get_activeproperties',[Property_controller::class,'get_activeproperties'])->name('get_active.properties');

    Route::get('property/{id}/edit',[Property_controller::class,'editproperty'])->name('property.edit');

    Route::post('updatespropertiesdetails/{id}',[Property_controller::class,'updatepropertiesdetails'])->name('updateproperties.details');


    Route::get('propertiescategories',[Propertycategory_controller::class,'get_propertycategories'])->name('propertiescategories');

    Route::get('propertiescategories',[Propertycategory_controller::class,'get_propertycategories'])->name('propertiescategories');

    Route::post('addedit/propertycat',[Propertycategory_controller::class,'storepropertycat'])->name('storepropertycat');

    Route::get('updatepropertycategorystatus',[Propertycategory_controller::class,'updatepropertycatstatus'])->name('updatepropertycategorystatus');

    Route::get('propertycategories/{id}/edit',[Propertycategory_controller::class,'edit_propertycategories'])->name('edit_propertycategories');

    Route::delete('delete_propertycat/{id}',[Propertycategory_controller::class,'delete_propertycategories'])->name('delete_propertycategories');

    Route::get('properties',[Property_controller::class,'properties'])->name('properties');

    
});
