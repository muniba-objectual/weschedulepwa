<?php

use App\Http\Livewire\WeSchedule\Pages\SignIn;
use App\Http\Livewire\WeSchedule\Pages\SignUp;
use App\Http\Livewire\WeSchedule\Pages\Dashboard;
use App\Http\Livewire\WeSchedule\Pages\StaffManagement;
use App\Http\Livewire\WeSchedule\Pages\HomeManagement;
use App\Http\Livewire\WeSchedule\Pages\ChildManagement;
use App\Http\Livewire\WeSchedule\Pages\ShiftManagementEntries;
use App\Http\Livewire\WeSchedule\Pages\Reports;
use App\Http\Livewire\WeSchedule\Pages\MyProfile;

use App\Http\Livewire\WeSchedule\PartialPages\UserProfile;

Route::group(['prefix'=>'we-schedule', 'as' => 'we-schedule.'], function (){
    
    Route::get('/' , SignIn::class)->name('signin');
    Route::get('signup' , SignUp::class)->name('signup');

    Route::get('dashboard' , Dashboard::class)->name('dashboard');
    Route::get('users/{id}' , UserProfile::class)->name('users');
    
    Route::get('staff-management' , StaffManagement::class)->name('staff-management');
    Route::get('home-management' , HomeManagement::class)->name('home-management');
    Route::get('child-management' , ChildManagement::class)->name('child-management');
    Route::get('shift-management-entries' , ShiftManagementEntries::class)->name('shift-management-entries');
    
    Route::get('reports' , Reports::class)->name('reports');

    Route::get('profile' , MyProfile::class)->name('profile');
});
