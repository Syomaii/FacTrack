<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FacultyReservationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
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
    Route::get('/password/reset', [UserController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [UserController::class, 'updatePassword'])->name('password.update');
    
    // Route::get('/', function () { return view('index'); })->name('login');
});



Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/notifications', [PageController::class, 'notifications'])->name('notifications');
    Route::get('/notifications/redirect/{id}', [NotificationController::class, 'redirect'])->name('redirect');
    Route::get('/equipment-details/{code}', [PageController::class, 'equipmentDetails'])->name('equipment-details');
    Route::get('/notifications/{status?}', [NotificationController::class, 'filter'])->name('notifications-filter');
    

    Route::middleware(['checkRole:student'])->group(function (){
        Route::get('/student-dashboard', [StudentController::class, 'studentDashboard'])->name('student.dashboard');
        Route::get('/student-profile/{id}', [StudentController::class, 'studentProfile'])->name('student.profile');
    });

    Route::middleware(['checkRole:faculty'])->group(function (){
        Route::get('/faculty-dashboard', [FacultyController::class, 'facultyDashboard'])->name('faculty.dashboard');
        Route::get('/faculty-profile/{id}', [FacultyController::class, 'facultyProfile'])->name('faculty.profile');
    });

    Route::middleware(['checkRole:faculty,student'])->group(function (){
        Route::get('/reserve-equipment/{code}', [ReservationController::class, 'showReservationForm'])->name('reserve.equipment');
        Route::post('/reserve-equipment/{code}', [ReservationController::class, 'storeReservation'])->name('reserve.equipment.store');
        Route::get('/api/search-equipment', [ReservationController::class, 'searchEquipment']);
        Route::get('/reserve-facility', [ReservationController::class, 'reserveFacility'])->name('reserve.reserve_facility');
        Route::get('/reserve-selected-facility/{id}', [ReservationController::class, 'facilityForReservation'])->name('facility_reservation');
        Route::post('/submit-reservation', [ReservationController::class, 'submitReservation'])->name('submit_reservation');
    });

//---------------------------------------Admin,and Student -----------------------------------------------
    Route::middleware(['checkRole:admin,faculty,student'])->group(function () {
        Route::get('/offices', [PageController::class, 'offices'])->name('offices');
        Route::get('/office/{id}', [OfficeController::class, 'officeFacilities'])->name('officeFacilities');
    });

 //---------------------------------------Admin, Operator, Facility Manager and Student -----------------------------------------------

    Route::middleware(['checkRole:admin,facility manager,operator,student,faculty'])->group(function () {
        Route::get('/facility-equipment/{id}', [PageController::class, 'facilityEquipments'])->name('facility_equipment');
    });

 //---------------------------------------Operator, Facility Manager and Student -----------------------------------------------

    Route::middleware(['checkRole:operator,facility manager,student,faculty'])->group(function () {
        Route::get('/reservation-details/{id}', [ReservationController::class, 'reservationDetails'])->name('reservation_details');
        Route::get('/facility-reservation-details/{id}', [ReservationController::class, 'facilityReservationDetails'])->name('facility_reservation_log');

    });
    

 //---------------------------------------Operator, Facility Manager and Admin -----------------------------------------------

    Route::middleware(['checkRole:admin,facility manager,operator'])->group(function (){
        Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile/{id}', [PageController::class, 'profile'])->name('profile');
        Route::put('/profile/{id}', [UserController::class, 'updateProfile'])->name('profile.update');

        Route::get('/add-student', [PageController::class, 'addStudent'])->name('add-student');
        Route::post('/add-studentPost', [StudentController::class, 'addStudentPost'])->name('add-studentPost');
        
        Route::get('/view-students', [StudentController::class, 'viewDepartment'])->name('view-students');
        Route::get('/department/{department}/students', [StudentController::class, 'viewStudentsByDepartment'])->name('view-department-students');
        Route::get('/search-student', [StudentController::class, 'search'])->name('search-student');
        Route::get('/student/{id}', [StudentController::class, 'studentProfile'])->name('student.show_profile');

        Route::put('/change-password/{id}', [UserController::class, 'changePassword'])->name('change_password');
        Route::get('/dashboard-search-user', [PageController::class, 'dashboardSearchUser'])->name('dashboard-search-user');
        
        Route::get('/add-faculty', [PageController::class, 'addFaculty'])->name('add-faculty');
        Route::post('/add-facultyPost', [FacultyController::class, 'addFacultyPost'])->name('add-facultyPost');
        
        Route::get('/view-faculties', [FacultyController::class, 'viewDepartment'])->name('view-faculties');
        Route::get('/department/{department}/faculties', [FacultyController::class, 'viewFacultyByDepartment'])->name('view-department-faculties');
        Route::get('/search-faculties', [FacultyController::class, 'search'])->name('search-faculty');
        Route::get('/faculty/{id}', [FacultyController::class, 'facultyProfile'])->name('faculty.show_profile');

    });


    //---------------------------------------Facility Manager and Admin -----------------------------------------------

    Route::middleware(['checkRole:admin,facility manager'])->group(function () {
        Route::get('/users', [PageController::class, 'users'])->name('users');
        Route::get('/add-user', [PageController::class, 'addUser'])->name('add-user');
        Route::get('/search-user', [UserController::class, 'searchUser'])->name('search-user');
        Route::post('/add-user', [UserController::class, 'addUserPost'])->name('addUserPost');
        //for student routes
        Route::get('/students', [PageController::class, 'students']);
        Route::post('/students', [FileUploadController::class, 'importStudents'])->name('import.file');

        Route::get('/faculties', [PageController::class, 'faculties']);
        Route::post('/faculties', [FileUploadController::class, 'importFaculties'])->name('faculty.import.file');
        
    });
    
    //----------------------------------------------------------------------------------------------------------------


    //-------------------------------------------------- Admin -------------------------------------------------------


    Route::middleware(['checkRole:admin'])->group(function () {
        Route::delete('/delete-office/{id}', [OfficeController::class, 'deleteOffice'])->name('deleteOffice');        
        Route::post('/add-office', [OfficeController::class, 'addOffice'])->name('addOffice');
        Route::put('/update-office/{id}', [OfficeController::class, 'updateOffice'])->name('updateOffice');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetUserPassword'])->name('users.reset_password');
        Route::get('/user-reports', [ReportController::class, 'userReports'])->name('user_reports');
        Route::get('/edit-date-range', [ReportController::class, 'setDateRangeUsers'])->name('edit-date-range');

    });
    // Route::get('/users', [PageController::class, 'users']);

    //----------------------------------------------------------------------------------------------------------------


    //---------------------------------------Facility Manager and Operator -----------------------------------------------
    
    Route::middleware(['checkRole:operator,facility manager'])->group(function () {

        //Page Controller
        Route::get('/facilities', [PageController::class, 'facilities'])->name('facilities');
        Route::get('/scan-code', [PageController::class, 'scanCode']);
        Route::get('/equipments', [PageController::class, 'equipments'])->name('equipments');
        Route::get('/borrowed-equipments', [ReportController::class, 'borrowedEquipmentReports'])->name('borrowed_equipments');
        Route::get('/borrowed-equipment-reports', [ReportController::class, 'getBorrowedEquipmentReports'])->name('borrowed.equipment.reports');
        Route::get('/maintenanced-equipments', [ReportController::class, 'maintenancedEquipmentReports']);
        Route::get('/repaired-equipments', [ReportController::class, 'repairedEquipmentReports']);
        Route::get('/repaired-equipment-reports', [ReportController::class, 'setDateRepairedEquipmentReports'])->name('repaired.equipment.reports');
        Route::get('/donated-equipments', [ReportController::class, 'donatedEquipmentReports'])->name('donated_equipments');
        Route::get('/donated-equipment-reports', [ReportController::class, 'setDateDonatedEquipmentReports'])->name('donated.equipment.reports');
        Route::get('/disposed-equipments', [ReportController::class, 'disposedEquipmentReports']);
        Route::get('/disposed-equipment-reports', [ReportController::class, 'setDateDisposedEquipmentReports'])->name('disposed.equipment.reports');
        Route::get('/borrowers-log', [PageController::class, 'borrowersLog'])->name('borrowersLog');
        Route::get('/equipment-reservations-log', [ReservationController::class, 'equipmentReservationLog'])->name('logs.equipment_reservations');
        Route::get('/facility-reservations-log', [ReservationController::class, 'facilityReservationLog'])->name('logs.facility_reservations');
        Route::post('/reservation/{id}/accept', [ReservationController::class, 'accept'])->name('reservation.accept');
        Route::post('/reservation/{id}/decline', [ReservationController::class, 'decline'])->name('reservation.decline');

        // Route::get('/product-details/{id}', [PageController::class, 'productDetails'])->name('product.details');
        
        //Equipment Controller
        Route::put('/equipments/update', [EquipmentController::class, 'updateEquipment'])->name('update_equipment');
        Route::get('/equipment-search', [EquipmentController::class, 'equipmentSearch'])->name('equipment_search');
        Route::get('/borrower-search', [PageController::class, 'borrowerSearch'])->name('borrower_search');

        
        //QRCodeController
        Route::get('/qr-code/{code}', [QRCodeController::class, 'index'])->name('qr_code');
        
        //BorrowerController
        // Route::get('/borrow-equipment', [TransactionController::class, 'borrowEquipment'])->name('borrow-equipment');
        // Route::post('/borrow-equipment', [TransactionController::class, 'borrowerFormPost']);
        // Route::post('/borrow-submit/{id}', [TransactionController::class, 'submitBorrow'])->name('borrow.submit');
        // Route::get('/borrow-details/{code}', [TransactionController::class, 'showDetails'])->name('borrow_details');

        Route::get('/borrow-equipment', [TransactionController::class, 'borrowEquipment'])->name('borrow_equipment');
        Route::post('/borrow-equipment', [TransactionController::class, 'borrowerFormPost']);
        Route::get('/borrow-details/{code}', [TransactionController::class, 'showBorrowDetails'])->name('borrow_details');
        Route::post('/borrow-equipment/{id}', [TransactionController::class, 'submitBorrow'])->name('borrow-equipment-post');
        Route::get('/search-students', [TransactionController::class, 'searchStudents'])->name('search.students');
        Route::get('/get-student-details/{id}', [TransactionController::class, 'getStudentDetails']);

        Route::get('/maintenance-equipment', [PageController::class, 'maintenance'])->name('maintenance_equipment');
        Route::get('/maintenance-equipment-details/{code}', [TransactionController::class, 'maintenanceDetails'])->name('maintenance-equipment-details');
        Route::post('equipments/{code}/maintenance', action: [TransactionController::class, 'submitMaintenance'])->name('maintenance-equipment-post');
        Route::get('/repair-equipment', [PageController::class, 'repairEquipment'])->name('repair_equipment');
        Route::get('/repair-equipment-details/{code}', [TransactionController::class, 'repairDetails'])->name('repair-equipment-details');
        Route::post('equipments/{code}/repair', [TransactionController::class, 'submitRepair'])->name('repair-equipment-post');
        Route::get('/dispose-equipment', [PageController::class, 'disposeEquipment'])->name('disposed_equipment');
        Route::get('/disposed-equipment-details/{code}', [TransactionController::class, 'disposedDetails'])->name('disposed-equipment-details');
        Route::post('equipments/{code}/disposed', [TransactionController::class, 'submitDisposed'])->name('disposed-equipment-post');
        Route::get('/donate-equipment', [PageController::class, 'donateEquipment'])->name('donated_equipment');
        Route::get('/donated-equipment-details/{code}', [TransactionController::class, 'donateDetails'])->name('donated-equipment-details');
        Route::post('equipments/{code}/donated', [TransactionController::class, 'submitDonated'])->name('donated-equipment-post');
        // Route::post('/maintenance-equipment-post/{id}', [PageController::class, 'maintenancePost'])->name('maintenance-equipment-post');

        Route::post('/validate-equipment-status', [TransactionController::class, 'validateEquipmentStatus']);

        Route::get('/return-equipment', [PageController::class, 'returnEquipment']);
        Route::post('/return-equipment/{code}', [TransactionController::class, 'returnEquipment'])->name('equipment.return');
    });

    //----------------------------------------------------------------------------------------------------------------

    //---------------------------------------Facility Manager---------------------------------------------------------

    Route::middleware(['checkRole:facility manager'])->group(function () {
        Route::get('/generatedqr', [PageController::class, 'generatedQr']);
        Route::get('/add-equipment/{id}', [PageController::class, 'addEquipment'])->name('add_equipment');
        Route::post('/add-equipment/{id}', [EquipmentController::class, 'addEquipmentPost'])->name('add_equipment');
        Route::get('/equipment-code/{code}', [EquipmentController::class, 'equipmentCode'])->name('added-equipment');
        
        Route::delete('/equipments/{id}', [EquipmentController::class, 'deleteEquipment'])->name('delete_equipment');

        Route::put('/equipments/update', [EquipmentController::class, 'updateEquipment'])->name('update_equipment');
        
        Route::delete('/delete-facility/{id}', [FacilityController::class, 'deleteFacility'])->name('deleteFacility'); 
        Route::get('/check-equipment/{id}', [FacilityController::class, 'checkEquipment'])->name('facility.checkEquipment');
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