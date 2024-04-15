<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $events = Event::orderBy('event_date', 'desc')->paginate(3);
    $links = $events->linkCollection(); // ページネーションリンクのコレクションを取得

    // 最初と最後のページへのリンクを手動で追加
    $firstPageLink = ['url' => $events->url(1), 'label' => '最初', 'active' => false];
    $lastPageLink = ['url' => $events->url($events->lastPage()), 'label' => '最後', 'active' => false];
    $links->prepend($firstPageLink); // コレクションの先頭に追加
    $links->push($lastPageLink); // コレクションの末尾に追加
    return Inertia::render('Event/Index', ['events' => $events, 'links' => $links]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render('Event/Create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'title' => 'required|max:255',
      'content' => 'required',
      'event_date' => 'required|date',
      'user_id' => 'required',
      'user_name' => 'required',
    ]);

    $event = new Event($validatedData);
    $event->user_id = auth()->id();
    $event->user_name = auth()->name;
    $event->save();

    return redirect()->route('event.create');
  }


  /**
   * Display the specified resource.
   */
  public function show(Event $event)
  {
    $applications = Application::with('user')->where('event_id', $event->id)->get();
    // dd($applications);
    return Inertia::render(
      'Event/Show',
      ['event' => $event, 'applications' => $applications]
    );
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Event $event)
  {
    $userName = $event->user->name;
    return Inertia::render('Event/Edit', [
      'eventData' => $event,
    ]);
  }

  public function update(Request $request, Event $event)
  {
    $validatedData = $request->validate([
      'title' => 'required|max:255',
      'content' => 'required',
      'event_date' => 'required|date',
    ]);
    $user_id  = auth()->id();
    $validatedData['user_id'] = $user_id;
    $event->update($validatedData);

    return redirect()->route('event.index')->with([
      'message' => '更新しました',
      'status' => 'success',
    ]);
  }

  public function destroy(Event $event)
  {
    $event->delete();
    return redirect()->route('event.index')->with('message', 'イベントを削除しました');
  }
}
