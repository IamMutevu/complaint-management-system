<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Product;
use App\CartItem;

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
    return view('frontend.home');
});


Route::get('/patient/identification', 'PagesController@identification')->name('patient_identification');
Route::post('/patient/register', 'PagesController@register_patient_user')->name('register_patient_user');
Route::post('/patient/authenticate', 'PagesController@authenticate_patient_user')->name('authenticate_patient_user');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', 'HomeController@admin_dashboard')->name('admin_dashbooard');
	Route::get('/patients', 'PatientsController@index')->name('patients');
	Route::get('/departments', 'DepartmentsController@index')->name('departments');
	Route::get('/staff', 'StaffController@index')->name('staff');
	Route::get('/complaint_categories', 'ComplaintCategoriesController@index')->name('complaint_categories');
	Route::get('/complaints', 'ComplaintsController@index')->name('complaints');
});

Route::group(['prefix' => 'dashboard'], function(){
	Route::get('/', 'HomeController@patient_dashboard')->name('patient_dashboard');
	Route::get('/complaints', 'ComplaintsController@index')->name('patient_complaints');
	Route::get('/profile', 'StudentsController@profile')->name('patient_profile');
	Route::get('/documents', 'DocumentsController@index')->name('patient_documents');
	Route::get('/opportunities', 'OpportunitiesController@index')->name('patient_opportunities');
	Route::get('/opportunity/apply', 'OpportunitiesController@index')->name('patient_opportunities');
});

Route::group(['prefix' => 'data'], function(){
	Route::post('/patient/dataTable', 'PatientsController@dataTable');
	Route::get('/patient/get_list', 'PatientsController@getList');
	Route::get('/patient/get_details/{id}', 'PatientsController@getByid');
	Route::post('/patient/create', 'PatientsController@create')->name('patient_create');
	Route::post('/patient/update', 'PatientsController@update')->name('patient_update');
	Route::get('/patient/delete/{id}', 'PatientsController@delete')->name('patient_delete');
	Route::post('/patient/check_duplicate', 'PatientsController@checkDuplicate')->name('patient_check_duplicate');

	Route::post('/department/dataTable', 'DepartmentsController@dataTable');
	Route::get('/department/get_list', 'DepartmentsController@getList');
	Route::get('/department/get_details/{id}', 'DepartmentsController@getByid');
	Route::post('/department/create', 'DepartmentsController@create')->name('department_create');
	Route::post('/department/update', 'DepartmentsController@update')->name('department_update');
	Route::get('/department/delete/{id}', 'DepartmentsController@delete')->name('department_delete');
	
	Route::post('/staff/dataTable', 'StaffController@dataTable');
	Route::get('/staff/get_list', 'StaffController@getList');
	Route::get('/staff/get_details/{id}', 'StaffController@getByid');
	Route::post('/staff/create', 'StaffController@create')->name('staff_create');
	Route::post('/staff/update', 'StaffController@update')->name('staff_update');
	Route::get('/staff/delete/{id}', 'StaffController@delete')->name('staff_delete');

	Route::post('/complaint_category/dataTable', 'ComplaintCategoriesController@dataTable');
	Route::get('/complaint_category/get_list', 'ComplaintCategoriesController@getList');
	Route::get('/complaint_category/get_details/{id}', 'ComplaintCategoriesController@getByid');
	Route::post('/complaint_category/create', 'ComplaintCategoriesController@create')->name('complaint_category_create');
	Route::post('/complaint_category/update', 'ComplaintCategoriesController@update')->name('complaint_category_update');
	Route::get('/complaint_category/delete/{id}', 'ComplaintCategoriesController@delete')->name('complaint_category_delete');

	Route::post('/complaint/dataTable', 'ComplaintsController@dataTable');
	Route::get('/complaint/get_list', 'ComplaintsController@getList');
	Route::get('/complaint/get_details/{id}', 'ComplaintsController@getByid');
	Route::post('/complaint/create', 'ComplaintsController@create')->name('complaint_create');
	Route::post('/complaint/update', 'ComplaintsController@update')->name('complaint_update');
	Route::get('/complaint/delete/{id}', 'ComplaintsController@delete')->name('complaint_delete');
	Route::get('/complaint/close/{id}', 'ComplaintsController@closeComplaint')->name('complaint_close');
});




