<?php

namespace Inovector\Mixpost\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    public function __invoke(): JsonResponse
    {
        Artisan::call('mixpost:run-scheduled-posts');
        $output = Artisan::output();

        return response()->json([
            'status' => 'success',
            'message' => 'Scheduled posts processed successfully.',
            'output' => trim($output)
        ]);
    }
}
