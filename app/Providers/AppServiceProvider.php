<?php

namespace App\Providers;

use App\Http\Livewire\Forms\CaseManage\ExpensesForm;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_UploadReceiptStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_ReviewStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_LinkingStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_SubmitStepComponent;

use App\Http\Livewire\TestStep1Component;
use App\Http\Livewire\TestStep2Component;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Livewire\Livewire;

use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('x-checkbox-field', \App\View\Components\CustomFormComponents\CheckboxField::class);
        Blade::component('x-date-range-field', \App\View\Components\CustomFormComponents\DateRangeField::class);
        Blade::component('x-input-field', \App\View\Components\CustomFormComponents\InputField::class);
        Blade::component('x-radio-field', \App\View\Components\CustomFormComponents\RadioField::class);
        Blade::component('x-textarea-field', \App\View\Components\CustomFormComponents\TextareaField::class);


        Schema::defaultStringLength(191);

        //
        Paginator::useBootstrap();

        //Livewire register components -- https://spatie.be/docs/laravel-livewire-wizard/v1/usage/creating-your-first-wizard

        Livewire::component('ExpenseWizard', ExpensesForm::class);

        Livewire::component('UploadReceipt', ExpensesForm_UploadReceiptStepComponent::class);
        Livewire::component('Review', ExpensesForm_ReviewStepComponent::class);
        Livewire::component('Linking', ExpensesForm_LinkingStepComponent::class);
        Livewire::component('Submit', ExpensesForm_SubmitStepComponent::class);

        Livewire::component('step1', TestStep1Component::class);
        Livewire::component('step2', TestStep2Component::class);

    }
}
