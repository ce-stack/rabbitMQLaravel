# Laravel RabbitMQ Learning Lab

## Project Description

This is a small Laravel backend project built to understand RabbitMQ in a real workflow.

The project focuses on one idea:

Laravel should not execute heavy work inside the HTTP request.

Instead, Laravel creates a record, sends a job to RabbitMQ, and lets a worker process it in the background.

## Main Goal

It is a focused backend lab for understanding:

- Message queues
- Background jobs
- Workers
- Retry behavior
- Failed job handling
- RabbitMQ dashboard monitoring

## Project Flow

The project follows this flow:

1. The user creates a report from a Laravel route.
2. Laravel saves the report in the database with a pending status.
3. Laravel dispatches a job to RabbitMQ.
4. RabbitMQ stores the message in the reports queue.
5. The Laravel worker consumes the job from RabbitMQ.
6. The worker processes the report.
7. The report status changes to completed or failed.

## Main Components

### Laravel

Laravel handles the request, creates the report record, dispatches the job, and updates the database.

### RabbitMQ

RabbitMQ works as the message broker.

It holds the job message until a worker consumes it.

RabbitMQ does not execute the job itself.

### Worker

The Laravel queue worker consumes messages from RabbitMQ and runs the job logic.

### Database

The database stores the report data and tracks the current processing status.

## Implemented Features

- RabbitMQ running through Docker
- RabbitMQ Management Dashboard enabled
- Laravel connected to RabbitMQ
- Dedicated reports queue
- Report model and database table
- Background job for report generation
- Successful job processing
- Failed job simulation
- Retry behavior with backoff
- Delay queue behavior
- Final failed status handling

## Success Scenario

A normal report is created with pending status.

The job is sent to RabbitMQ.

The worker consumes the job.

The report is processed.

The final status becomes completed.

## Failure Scenario

A failing report is created with pending status.

The job is sent to RabbitMQ.

The worker tries to process it.

The job fails intentionally.

Laravel retries the job several times.

RabbitMQ creates a temporary delay queue during the backoff period.

After all retries fail, the report status becomes failed.


## Key RabbitMQ Concepts Covered

- Queue
- Producer
- Consumer
- Worker
- Message
- Acknowledgment
- Retry
- Backoff
- Delay queue
- Failed job
