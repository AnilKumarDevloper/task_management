<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\AdditionalRightsRequestController;
use App\Http\Controllers\Backend\AuthorityMatrixController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DocumentController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\FinancialYearListController;
use App\Http\Controllers\Backend\FolderPermissionController;
use App\Http\Controllers\Backend\MainFolderController;
use App\Http\Controllers\Backend\MonthFolderController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TaskController;
use App\Http\Controllers\Backend\TicketController;
use App\Http\Controllers\Backend\YearFolderController;
use App\Http\Controllers\ProfileController;
use App\Models\Backend\YearFolder;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function(){
        Route::get('/', 'SuperAdminLoginCreate')->name('login');
        Route::get('login', 'SuperAdminLoginCreate')->name('login');
        Route::post('login', 'SuperAdminLoginStore')->name('login_store');
        Route::get('verify-otp/{id}', 'SuperAdminLoginVerifyOtpView')->name('verify_otp_view');
        Route::post('verify-otp', 'SuperAdminLoginVerifyOtp')->name('verify_otp_submit');
    });
});

Route::middleware(['auth','verified'])->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/admin','DashboardRedirect')->name('backend.dashboard.redirect');
        Route::get('/admin/dashboard','Dashboard')->name('backend.dashboard.view');
    });
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
 
    Route::controller(EmployeeController::class)->group(function(){
        Route::prefix('/admin/employee')->group(function(){
            Route::get('/', 'index')->name('backend.employee.index');
            Route::get('/create', 'create')->name('backend.employee.create');
            Route::get('/edit/{id}', 'edit')->name('backend.employee.edit');
            Route::post('/store', 'store')->name('backend.employee.store');
            Route::post('/update/{id}', 'update')->name('backend.employee.update');
            Route::delete('/destroy/{id}', 'destroy')->name('backend.employee.destroy'); 
            Route::get('/change-status', 'changeStatus')->name('backend.employee.change_status');
            Route::get('/view-employee-tasks/{id}', 'viewEmployeeTasks')->name('backend.employee.view_employee_tasks');
        });
    });
    Route::controller(ClientController::class)->group(function(){
        Route::prefix('/admin/client')->group(function(){
            Route::get('/', 'index')->name('backend.client.index');
            Route::get('/view/{id}', 'view')->name('backend.client.view');
            Route::get('/create', 'create')->name('backend.client.create');
            Route::get('/edit/{id}', 'edit')->name('backend.client.edit');
            Route::post('/store', 'store')->name('backend.client.store');
            Route::post('/update/{id}', 'update')->name('backend.client.update');
            Route::delete('/destroy/{id}', 'destroy')->name('backend.client.destroy');
            Route::get('/change-status', 'changeStatus')->name('backend.client.change_employee');
        });
    });
    // Route::controller(MainFolderController::class)->group(function(){
    //     Route::prefix('/admin/main-folder')->group(function(){
    //         Route::get('/', 'index')->name('backend.main_folder.index');
    //     });
    // }); 

    Route::controller(YearFolderController::class)->group(function(){
        Route::prefix('/admin/years-folder')->group(function(){
            Route::get('/{main_f_id}', 'index')->name('backend.year_folder.index');
            Route::post('/store', 'store')->name('backend.year_folder.store');
        });
    });
    Route::controller(MonthFolderController::class)->group(function(){
        Route::prefix('/admin/months-folder')->group(function(){
            Route::get('/{main_f_id}/{year_f_id}', 'index')->name('backend.month_folder.index');
        });
    });
    Route::controller(DocumentController::class)->group(function(){
        Route::prefix('/admin/document')->group(function(){
            Route::get('/{main_f_id}/{year_f_id}/{month_f_id}', 'index')->name('backend.document.index');
            Route::post('/store', 'store')->name('backend.document.store');
            Route::get('/get_document', 'getDocument')->name('backend.document.get_document');
            Route::post('/update', 'update')->name('backend.document.update');
            Route::get('/destroy', 'destroy')->name('backend.document.destroy');
        });
    });
    Route::controller(TaskController::class)->group(function(){
        Route::prefix('/admin/task')->group(function(){
            Route::get('/', 'index')->name('backend.task.index');
            Route::post('store', 'store')->name('backend.task.store');
            Route::post('store-from-task-list', 'storeFromTaskList')->name('backend.task.store_from_task_list');
            Route::get('/view/{task_id}', 'view')->name('backend.task.view');
            Route::get('/edit/{task_id}', 'edit')->name('backend.task.edit');
            Route::post('/update/{task_id}', 'update')->name('backend.task.update');
            Route::post('/comment', 'commentOnTask')->name('backend.task.comment_on_task');
            Route::post('/reply', 'replyOnComment')->name('backend.task.reply_on_comment');
            Route::get('/destroy', 'destroy')->name('backend.task.destroy');
            Route::get('/assign-task', 'assignTask')->name('backend.task.assign');
            Route::get('/doc/{doc_id}', 'viewTaskDoc')->name('backend.task.view_doc');
            Route::get('/get-task-list', 'getTaskList')->name('api.get_task_list');
            Route::get('/download-task-doc/{doc_id}', 'downloadTaskDoc')->name('backend.task.download_task_doc');
            Route::get('/send-reminder', 'sendTaskReminder')->name('backend.task.send_reminder');
            Route::get('/export-csv/{client_id}/{year}/{month}', 'taskExportCSV')->name('backend.task.export_csv');
            Route::post('/import-csv/{client_id}', 'taskImportCSV')->name('backend.task.import_csv');
        }); 
    }); 
    Route::controller(FolderPermissionController::class)->group(function(){
        Route::prefix('/admin/folder-permission')->group(function(){
            Route::get('/send-folder-permission-page', 'sendFolderPermissionPage')->name('backend.folder_permission.send_folder_permission_page');
            Route::get('/create/{employee_id}/{client_id}', 'create')->name('backend.folder_permission.create');
        });
    });
    Route::controller(ProfileController::class)->group(function(){
        Route::prefix('/admin/profile')->group(function(){
            Route::get('/', 'index')->name('backend.profile.index');
            Route::post('/update', 'update')->name('backend.profile.update');
        });
    });
    Route::controller(TicketController::class)->group(function(){
        Route::prefix('/admin/ticket')->group(function(){
            Route::get('/', 'index')->name('backend.ticket.index'); 
            Route::get('/create', 'create')->name('backend.ticket.create'); 
            Route::post('/store', 'store')->name('backend.ticket.store'); 
            Route::get('/view/{id}', 'view')->name('backend.ticket.view'); 
            Route::post('/comment', 'commentOnTicket')->name('backend.ticket.comment'); 
            Route::get('/update-current-status', 'updateCurrentStatus')->name('backend.ticket.update_current_status'); 
            Route::get('/view-ticket-doc/{file}', 'viewTicketDoc')->name('backend.ticket.view_ticket_doc');
            Route::get('/send-reminder', 'sendTicketReminder')->name('backend.ticket.send_reminder');
        });
    });
    Route::controller(FinancialYearListController::class)->group(function(){
        Route::prefix('admin/fy_year')->group(function(){
            Route::get('/', 'index')->name('backend.fy_year.index');
            Route::get('/create', 'create')->name('backend.fy_year.create');
            Route::post('/store', 'store')->name('backend.fy_year.store');
            Route::get('/edit/{id}', 'edit')->name('backend.fy_year.edit');
            Route::post('/update', 'update')->name('backend.fy_year.update');
        });
    });
    Route::controller(NotificationController::class)->group(function(){
        Route::prefix('admin/notification')->group(function(){
            Route::get('/', 'index')->name('backend.notification.index');
            Route::get('/view/{id}', 'viewNotification')->name('backend.notification.view');
        });
    });
    Route::controller(AuthorityMatrixController::class)->group(function(){
        Route::prefix('admin/authority-matrix')->group(function(){
            Route::get('/', 'index')->name('backend.authority_matrix.index'); 
            Route::get('/rights/{user_id}', 'createRights')->name('backend.authority_matrix.rights');
            Route::post('/sync-rights', 'syncRights')->name('backend.authority_matrix.sync_rights');
        });
    });
    Route::controller(AdditionalRightsRequestController::class)->group(function(){
        Route::prefix('admin/additional-rights-request')->group(function(){
            Route::get('/', 'index')->name('backend.additional_rights_request.index');
            Route::get('/create', 'create')->name('backend.additional_rights_request.create');
            Route::post('/store', 'store')->name('backend.additional_rights_request.store');
            Route::get('/view/{req_id}', 'view')->name('backend.additional_rights_request.view');
            Route::get('/update-current-status', 'updateCurrentStatus')->name('backend.additional_rights_request.update_current_status'); 
            Route::post('/comment', 'commentOnRequest')->name('backend.additional_rights_request.comment'); 
            Route::get('/view-requet-doc/{file}', 'viewRequestDoc')->name('backend.additional_rights_request.view_ticket_doc');  
        });
    });

    Route::controller(SettingController::class)->group(function(){
        Route::prefix('admin/setting')->group(function(){
            Route::get('/layout-color', 'layoutColor')->name('backend.setting.layout_color');
            Route::post('/update-layout-color', 'updateLayoutSetting')->name('backend.setting.update_layout_color');
            Route::post('/update-default-layout', 'updateDefaultLayout')->name('backend.setting.update_default_layout');
        });
    });

});