<?php

namespace App\Jobs;

use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use RuntimeException;
use Throwable;

class GenerateReportJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $backoff = 5;

    public function __construct(
        public int $reportId
    ) {}

    public function handle(): void
    {
        $report = Report::find($this->reportId);

        if (! $report) {
            return;
        }

        $report->update([
            'status' => 'processing',
            'result' => 'Worker started. Attempt number: ' . $this->attempts(),
        ]);

        sleep(3);

        if (str_contains($report->title, 'FAIL')) {
            throw new RuntimeException('Report generation failed intentionally.');
        }

        $report->update([
            'status' => 'completed',
            'result' => 'Report generated successfully by RabbitMQ Worker',
            'processed_at' => now(),
        ]);
    }

    public function failed(Throwable $exception): void
    {
        $report = Report::find($this->reportId);

        if (! $report) {
            return;
        }

        $report->update([
            'status' => 'failed',
            'result' => $exception->getMessage(),
            'processed_at' => now(),
        ]);
    }
}