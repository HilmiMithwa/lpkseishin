<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/teacher/progress-report', 'GET', [
    'batch_id' => 1,
    'class_id' => 1,
    'draw' => 1,
    'columns' => [
        [ 'data' => 'formatted_id', 'name' => 'users.id', 'searchable' => 'true', 'orderable' => 'true' ],
        [ 'data' => 'name', 'name' => 'users.name', 'searchable' => 'true', 'orderable' => 'true' ]
    ],
    'search' => ['value' => '', 'regex' => 'false']
]);

// Since we are not authenticated, let's login a user!
// Find the teacher user.
$app->boot();
$user = \App\Models\User::where('role', 'guru')->first();
$app->make('auth')->login($user);

$response = $kernel->handle($request);
echo $response->getContent();

