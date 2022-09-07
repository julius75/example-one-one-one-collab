<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', function () {
    return redirect()->route('system.dashboard');
});

// redirect login to the desired auth login page
Route::get('/login', function () {
    return redirect()->to('auth/login');
});

Route::get('log-viewer', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('/test23', function () {
});



/**
 * external entries
 */
\Illuminate\Support\Facades\Route::get('/self-registration', function () {
    return view('evaluation::externalEntries.self-registration');
})->name('self-registration');

//@todo verify patient exists
\Illuminate\Support\Facades\Route::get('/self-assessment/{patient}', function () {
    return view('evaluation::externalEntries.self-assessment');
})->name('self-assessment');

\Illuminate\Support\Facades\Route::get('/assessment-wheel/{patient}', function ($system_id) {
    $patient = \Ignite\Reception\Entities\Patients::where('system_id', $system_id)->firstOrFail();

    $assessment = \Ignite\Evaluation\Entities\EablAssessmentWheel::where('patient_id', $patient->id)->latest()->first();

    return view('evaluation::externalEntries.assessment-wheel', compact('assessment'));
})->name('self-assessment');
