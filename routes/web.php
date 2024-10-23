<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes(['reset' => true]);


Route::fallback(function () {
    return redirect('/error404');
});


Route::get('/error401', [PageController::class, 'error401']);
Route::get('/error404', [PageController::class, 'error404']);



Route::middleware(['guest'])->group(function () {
    Route::post('/', [UserController::class, 'loginUser'])->name('login.post');
    Route::get('/', [PageController::class,'login'])->name('login');     
    
    // Route::get('/', function () { return view('index'); })->name('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile/{id}', [PageController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}', [UserController::class, 'updateProfile'])->name('profile.update');

    //---------------------------------------Facility Manager and Admin -----------------------------------------------

    Route::middleware(['checkRole:admin,facility manager'])->group(function () {
        Route::get('/users', [PageController::class, 'users'])->name('users');
        Route::get('/add-user', [PageController::class, 'addUser'])->name('add-user');
        Route::post('/add-user', [UserController::class, 'addUserPost'])->name('addUserPost');
        Route::put('/change-password/{id}', [UserController::class, 'changePassword'])->name('change_password');
        Route::get('/facility-equipment/{id}', [PageController::class, 'facilityEquipments'])->name('facility_equipment');
        
        //example only
        Route::get('/students', [PageController::class, 'students']);
        Route::post('/students', [FileUploadController::class, 'importStudents'])->name('import.file');
    });
    
    //----------------------------------------------------------------------------------------------------------------


    //-------------------------------------------------- Admin -------------------------------------------------------


    Route::middleware(['checkRole:admin'])->group(function () {
        Route::get('/offices', [PageController::class, 'offices'])->name('offices');
        Route::delete('/delete-office/{id}', [OfficeController::class, 'deleteOffice'])->name('deleteOffice');        
        Route::post('/add-office', [OfficeController::class, 'addOffice'])->name('addOffice');
        Route::put('/update-office/{id}', [OfficeController::class, 'updateOffice'])->name('updateOffice');
        Route::get('/office/{id}', [OfficeController::class, 'officeFacilities'])->name('officeFacilities');
    });
    // Route::get('/users', [PageController::class, 'users']);

    //----------------------------------------------------------------------------------------------------------------


    //---------------------------------------Facility Manager and Operator -----------------------------------------------
    
    Route::middleware(['checkRole:operator,facility manager'])->group(function () {

        //Page Controller
        Route::get('/scan-code', [PageController::class, 'scanCode']);
        Route::get('/equipments', [PageController::class, 'equipments'])->name('equipments');
        Route::get('/borrowed-equipments', [ReportController::class, 'borrowedEquipmentReports']);
        Route::get('/maintenanced-equipments', [ReportController::class, 'maintenancedEquipmentReports']);
        Route::get('/repaired-equipments', [ReportController::class, 'repairedEquipmentReports']);
        Route::get('/equipment-details/{code}', [PageController::class, 'equipmentDetails']);
        Route::get('/borrowers-log', [PageController::class, 'borrowersLog'])->name('borrowersLog');
        // Route::get('/product-details/{id}', [PageController::class, 'productDetails'])->name('product.details');
        
        //Equipment Controller
        Route::put('/equipments/update', [EquipmentController::class, 'updateEquipment'])->name('update_equipment');
        
        //QRCodeController
        Route::get('/qr-code/{code}', [QRCodeController::class, 'index'])->name('qr_code');
        
        //BorrowerController
        // Route::get('/borrow-equipment', [TransactionController::class, 'borrowEquipment'])->name('borrow-equipment');
        // Route::post('/borrow-equipment', [TransactionController::class, 'borrowerFormPost']);
        // Route::post('/borrow-submit/{id}', [TransactionController::class, 'submitBorrow'])->name('borrow.submit');
        // Route::get('/borrow-details/{code}', [TransactionController::class, 'showDetails'])->name('borrow_details');

<<<<<<< HEAD
        Route::get('/borrow-equipment', [BorrowerController::class, 'borrowEquipment'])->name('borrow_equipment');
        Route::post('/borrow-equipment', [BorrowerController::class, 'borrowerFormPost']);
        Route::get('/borrow-details/{code}', [BorrowerController::class, 'showBorrowDetails'])->name('borrow_details');
        Route::post('/borrow-equipment/{id}', [BorrowerController::class, 'submitBorrow'])->name('borrow-equipment-post');
        Route::get('/maintenance-equipment', [PageController::class, 'maintenance'])->name('maintenance-equipment');
        Route::get('/maintenance-equipment-details/{code}', [PageController::class, 'maintenanceDetails'])->name('maintenance-equipment-details');

        // Route::post('/maintenance-equipment-post/{id}', [PageController::class, 'maintenancePost'])->name('maintenance-equipment-post');

        Route::post('/validate-equipment-status', [BorrowerController::class, 'validateEquipmentStatus']);
=======
        Route::get('/borrow-equipment', [TransactionController::class, 'borrowEquipment'])->name('borrow_equipment');
        Route::post('/borrow-equipment', [TransactionController::class, 'borrowerFormPost']);
        Route::get('/borrow-details/{code}', [TransactionController::class, 'showBorrowDetails'])->name('borrow_details');
        Route::post('/borrow-equipment/{id}', [TransactionController::class, 'submitBorrow'])->name('borrow-equipment-post');
        Route::post('/validate-equipment-status', [TransactionController::class, 'validateEquipmentStatus']);
>>>>>>> e45afc819a0225225b9fb6611cf9750f79645f00

        Route::get('/return-equipment', [PageController::class, 'returnEquipment']);
        Route::post('/return-equipment', [TransactionController::class, 'returnEquipment'])->name('return.equipment');
    });

    //----------------------------------------------------------------------------------------------------------------

    //---------------------------------------Facility Manager---------------------------------------------------------

    Route::middleware(['checkRole:facility manager'])->group(function () {
        Route::get('/generatedqr', [PageController::class, 'generatedQr']);
        Route::get('/facilities', [PageController::class, 'facilities'])->name('facilities');
        Route::get('/add-equipment/{id}', [PageController::class, 'addEquipment'])->name('add_equipment');
        Route::post('/add-equipment/{id}', [EquipmentController::class, 'addEquipmentPost'])->name('add_equipment');
        Route::delete('/equipments/{id}', [EquipmentController::class, 'deleteEquipment'])->name('delete_equipment');

        Route::put('/equipments/update', [EquipmentController::class, 'updateEquipment'])->name('update_equipment');
        
        Route::delete('/delete-facility/{id}', [FacilityController::class, 'deleteFacility'])->name('deleteFacility');        
        Route::post('/add-facility', [FacilityController::class, 'addFacility'])->name('addFacility');
        Route::put('/update-facility/{id}', [FacilityController::class, 'updateFacility'])->name('updateFacility');
    });

    //-----------------------------------------------------------------------------------------------------------------
    
});


/*
    For capstone 42 new database addition
        1. Timeline table
            PK id
            FK equipment_id
            FK user_id
               

        2. Missing table
            PK id
            FK equipment_id
            FK user_id
               missing_date
               status


        3. Missing FK office_id in facility


*/