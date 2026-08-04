<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRegisterRequest;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Enums\EventStatus;


class EventController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $statuses = EventStatus::cases();
        return view('event.create', compact('categories', 'statuses'));
    }

    public function store(EventRegisterRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('event_images', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        $validatedData['user_id'] = Auth::id();
        Event::create($validatedData);

        return redirect()->route('home')->with('success', 'イベントが作成されました。');
    }
}
