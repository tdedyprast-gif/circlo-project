<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseCohortWizardController;
use App\Http\Controllers\Admin\MaterialAssignmentWizardController;


Route::get('/', function () {
    return view('philanthropy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Wizard 1: Course + Cohort
    Route::get('courses/create-wizard', [CourseCohortWizardController::class, 'create'])->name('courses.wizard.create');
    Route::post('courses/create-wizard', [CourseCohortWizardController::class, 'store'])->name('courses.wizard.store');

    // Wizard 2: Material + Assignment
    Route::get('materials/create-wizard', [MaterialAssignmentWizardController::class, 'create'])->name('materials.wizard.create');
    Route::post('materials/create-wizard', [MaterialAssignmentWizardController::class, 'store'])->name('materials.wizard.store');
});