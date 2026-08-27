<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('sort_order', 'asc')->get();
        $statuses = EventStatus::cases();
        return view('event.create', compact('categories', 'statuses'));
    }

    public function store(EventRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('event_images', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        $event = Auth::user()->events()->create($validatedData);

        return redirect()->route('home')->with('success', 'イベントを作成しました。');
    }

    public function show(Event $event)
    {
        abort_if($event->user_id !== Auth::id(), 403);

        return view('event.show', compact('event'));
    }

    public function edit(Event $event)
    {
        abort_if($event->user_id !== Auth::id(), 403);

        $categories = Category::orderBy('sort_order', 'asc')->get();
        $statuses = EventStatus::cases();
        return view('event.edit', compact('event', 'categories', 'statuses'));
    }

    public function update(EventRequest $request, Event $event)
    {
        abort_if($event->user_id !== Auth::id(), 403);

        $validatedData = $request->validated();

        if ($request->hasFile('image_path')) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
            $imagePath = $request->file('image_path')->store('event_images', 'public');
            $validatedData['image_path'] = $imagePath;
        }

        $event->update($validatedData);

        return redirect()->route('event.show', $event->id)->with('success', 'イベントを更新しました。');
    }

    public function destroy(Event $event)
    {
        abort_if($event->user_id !== Auth::id(), 403);

        $event->delete();

        return redirect()->route('home')->with('success', 'イベントを削除しました。');
    }
}
