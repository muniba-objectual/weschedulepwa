<?php

use App\Http\Livewire\CaseManage\Pages\SignIn;
use App\Http\Livewire\CaseManage\Pages\SignUp;
use App\Http\Livewire\CaseManage\Pages\Dashboard;
use App\Http\Livewire\CaseManage\Pages\Reports;
use App\Http\Livewire\CaseManage\Pages\MyProfile;

use App\Http\Livewire\CaseManage\PartialPages\UserProfile;
use App\Http\Livewire\CaseManage\PartialPages\ReportExpenses;
use App\Http\Livewire\CaseManage\PartialPages\ReportBankDeposits;

Route::group(['prefix'=>'case-manage', 'as' => 'case-manage.'], function (){
    
    Route::get('/' , SignIn::class)->name('signin');
    Route::get('signup' , SignUp::class)->name('signup');

    Route::get('dashboard' , Dashboard::class)->name('dashboard');
    
    Route::get('reports' , Reports::class)->name('reports');
    Route::get('reports/expenses' , ReportExpenses::class)->name('reports.expenses');
    Route::get('reports/bank-deposits' , ReportBankDeposits::class)->name('reports.bank-deposits');

    Route::get('profile' , MyProfile::class)->name('profile');
});
