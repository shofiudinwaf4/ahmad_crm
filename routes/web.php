<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'index']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // project
    Route::get('/project', [ProjectController::class, 'index']);
    Route::get('/doneProject', [ProjectController::class, 'done']);
    Route::get('/addProdukProject/{id}', [ProjectController::class, 'create']);
    Route::get('/editProdukProject/{id}', [ProjectController::class, 'edit']);
    Route::post('/storeProdukProject/{id}', [ProjectController::class, 'store']);
    Route::post('/changeCustomer/{id}', [ProjectController::class, 'changeCustomer']);
    Route::put('/updateProdukProject/{id}', [ProjectController::class, 'update']);
    Route::get('/bayar/{id}', [ProjectController::class, 'show']);

    // Customer
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/layanan/{id}', [CustomerController::class, 'show']);
    Route::put('/updateIsActiveLayanan/{id}', [CustomerController::class, 'updateIsActiveLayanan']);

    Route::get('/logout', [AuthController::class, 'logout']);
});
Route::middleware(['auth', 'role:Sales'])->group(function () {
    // leads
    Route::get('/leads', [LeadsController::class, 'index']);
    Route::get('/addLeads', [LeadsController::class, 'create']);
    Route::get('/editLeads/{id}', [LeadsController::class, 'edit']);
    Route::post('/storeLeads', [LeadsController::class, 'store']);
    Route::put('/updateLeads/{id}', [LeadsController::class, 'update']);
    Route::put('/updateStatusLeads/{id}', [LeadsController::class, 'updateStatusLeads']);
    Route::delete('/deleteLeads/{id}', [LeadsController::class, 'destroy']);
});
Route::middleware(['auth', 'role:Manager'])->group(function () {
    // produk
    Route::get('/produk', [ProdukController::class, 'index']);
    Route::get('/addProduk', [ProdukController::class, 'create']);
    Route::post('/storeProduk', [ProdukController::class, 'store']);
    Route::get('/editProduk/{id}', [ProdukController::class, 'edit']);
    Route::put('/updateProduk/{id}', [ProdukController::class, 'update']);
    Route::delete('/deleteProduk/{id}', [ProdukController::class, 'destroy']);

    Route::put('/updateApprovalProject/{id}', [ProjectController::class, 'updateApprovalProject']);

    Route::get('/reportLead', [ReportController::class, 'Lead']);
    Route::get('/report/lead/export', [ReportController::class, 'exportLead']);
    Route::get('/reportProject', [ReportController::class, 'Project']);
    Route::get('/report/project/export', [ReportController::class, 'exportProject']);
    Route::get('/reportCustomer', [ReportController::class, 'Customer']);
    Route::get('/report/customer/export', [ReportController::class, 'exportCustomer']);
});
