<?php

namespace App\Http\Controllers;

use App\Events\MessageBroadcast;
use App\Events\MessageSent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use DateTime;

class MessageController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('messages.index');
    }

    public function private(): Factory|View|Application
    {
        return view('messages.private');
    }

    public function store(Request $request)
    {
        switch ($request->input('channel'))
        {
            case 'public':
                MessageBroadcast::dispatch(
                    $request->input('name'),
                    $request->input('message'),
                    (new DateTime)->format('Y-m-d H:i:s')
                );
                break;
            case 'private':
                MessageSent::dispatch(
                    $request->input('name'),
                    $request->input('message'),
                    (new DateTime)->format('Y-m-d H:i:s')
                );
                break;
        }
    }
}
