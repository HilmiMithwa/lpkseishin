<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\User;

class DebugCommand extends Command
{
    protected $signature = 'debug:datatables';
    protected $description = 'Debug DataTables';

    public function handle()
    {
        $user = User::first();
        auth()->login($user);

        $request = Request::create('/teacher/progress-report', 'GET', [
            'batch_id' => 1,
            'class_id' => 1,
            'draw' => 1,
            'columns' => [
                [ 'data' => 'formatted_id', 'name' => 'users.id', 'searchable' => 'true', 'orderable' => 'true' ],
                [ 'data' => 'name', 'name' => 'users.name', 'searchable' => 'true', 'orderable' => 'true' ]
            ],
            'search' => ['value' => '', 'regex' => 'false']
        ]);
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');

        try {
            $controller = app()->make(\App\Http\Controllers\Teacher\ProgressReportController::class);
            $response = $controller->index($request);
            $this->info('Response: ' . $response->getContent());
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}
