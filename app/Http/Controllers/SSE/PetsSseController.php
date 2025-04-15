<?php

namespace App\Http\Controllers\SSE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Response;

class PetsSseController extends Controller
{
    public function stream(Request $request)
    {
        $headers = [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ];

        $response = Response::stream(function () use ($request) {
            while (true) {
                $page = $request->get('page', 1);
                $pets = Pet::with('owner')->paginate(45, ['*'], 'page', $page);

                echo "data: " . json_encode($pets->items()) . "\n\n";
                ob_flush();
                flush();

                sleep(5);

                if (connection_aborted()) {
                    break;
                }
            }
        }, 200, $headers);

        return $response;
    }
}
