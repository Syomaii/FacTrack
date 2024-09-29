<?php

use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return redirect('/error404');
});


Route::get('/error401', [PageController::class, 'error401']);
Route::get('/error404', [PageController::class, 'error404']);


//PageController
Route::middleware(['guest'])->group(function () {
    Route::post('/', [UserController::class, 'loginUser'])->name('login.post');
    Route::get('/', [PageController::class,'login'])->name('login');     
    
    // Route::get('/', function () { return view('index'); })->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard']);
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware(['checkRole:admin,facility manager'])->group(function () {
        Route::get('/users', [PageController::class, 'users']);
        Route::get('/add-user', [PageController::class, 'addUser'])->name('add-user');
        Route::post('/add-user', [UserController::class, 'addUserPost'])->name('addUserPost');
    });
        // Route::get('/users', [PageController::class, 'users']);
    Route::get('/offices', [PageController::class, 'offices'])->middleware(['checkRole:admin']);


    //facility manager
    Route::middleware(['checkRole:operator,facility manager'])->group(function () {
        //Page Controller
        Route::get('/scan-code', [PageController::class, 'scanCode']);
        Route::get('/return-equipment', [PageController::class, 'returnEquipment']);
        Route::get('/equipments', [PageController::class, 'equipments'])->name('equipments');
        Route::get('/borrowed-equipments', [PageController::class, 'borrowedEquipmentReports']);
        Route::get('/equipment-details/{code}', [PageController::class, 'equipmentDetails']);
        // Route::get('/product-details/{id}', [PageController::class, 'productDetails'])->name('product.details');
        
        //Equipment Controller
        Route::put('/equipments/update', [EquipmentController::class, 'updateEquipment'])->name('update_equipment');
        
        //QRCodeController
        Route::get('/qr-code/{code}', [QRCodeController::class, 'index'])->name('qr_code');
        
        //BorrowerController
        Route::get('/borrow-equipment/', [BorrowerController::class, 'borrowEquipment'])->name('borrow-equipment');
        Route::post('/borrower-form', [BorrowerController::class, 'borrowerFormPost']);
        Route::get('/borrow-details/{code}', [BorrowerController::class, 'showDetails']);
    });


    //Operators
    Route::middleware(['checkRole:facility manager'])->group(function () {
        Route::get('/generatedqr', [PageController::class, 'generatedQr']);
        Route::get('/facility-equipment/{id}', [PageController::class, 'facilityEquipments'])->name('facility_equipments');
        Route::get('/facilities', [PageController::class, 'facilities']);
        Route::get('/add-equipment/{id}', [PageController::class, 'addEquipment'])->name('add_equipment');
        Route::post('/add-equipment', [EquipmentController::class,'addEquipmentPost']);
        Route::delete('/equipments/{id}', [EquipmentController::class, 'deleteEquipment'])->name('delete_equipment');

        Route::put('/equipments/update', [EquipmentController::class, 'updateEquipment'])->name('update_equipment');
        
        Route::delete('/delete-facility/{id}', [FacilityController::class, 'deleteFacility'])->name('deleteFacility');        
        Route::post('/add-facilities', [FacilityController::class, 'addFacility'])->name('addFacility');
        Route::put('/update-facility/{id}', [FacilityController::class, 'updateFacility'])->name('updateFacility');
    });
    
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