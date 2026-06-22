<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\GenerateReportJob;
use App\Models\Report;



Route::get('/', function () {
    return view('welcome');
});



Route::get('/reports/create', function () {
    $report = Report::create([
        'title' => 'Sales Report ' . now()->format('H:i:s'),
        'status' => 'pending',
    ]);

    GenerateReportJob::dispatch($report->id)->onQueue('reports');

    return [
        'message' => 'Report created and job sent to RabbitMQ',
        'report_id' => $report->id,
        'status' => $report->status,
    ];
});

Route::get('/reports/create-fail', function () {
    $report = Report::create([
        'title' => 'FAIL Report ' . now()->format('H:i:s'),
        'status' => 'pending',
    ]);

    GenerateReportJob::dispatch($report->id)->onQueue('reports');

    return [
        'message' => 'Failing report created and job sent to RabbitMQ',
        'report_id' => $report->id,
        'status' => $report->status,
    ];
});

Route::get('/reports/{report}', function (Report $report) {
    return $report;
});