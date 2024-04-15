<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $events = Event::orderBy('event_date', 'desc')->paginate(3);
    $links = $events->linkCollection(); // ページネーションリンクのコレクションを取得
    foreach ($events as $event) {
      $event->applications = Application::with('user')->where('event_id', $event->id)->get();
    }

    // 最初と最後のページへのリンクを手動で追加
    $firstPageLink = ['url' => $events->url(1), 'label' => '最初', 'active' => false];
    $lastPageLink = ['url' => $events->url($events->lastPage()), 'label' => '最後', 'active' => false];
    $links->prepend($firstPageLink); // コレクションの先頭に追加
    $links->push($lastPageLink); // コレクションの末尾に追加
    return Inertia::render('Admin/Index', ['events' => $events, 'links' => $links]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'event_id' => 'required|exists:events,id',
      'apply_date' => 'required|date',
      'is_paid' => 'required',
    ]);

    $validatedData['user_id'] = auth()->id();

    $application = Application::create($validatedData);

    return redirect()->route('event.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(Application $application)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Application $application)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Application $application)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Application $application)
  {
    $application->delete();
    return redirect()->route('event.index')->with('message', '申込みをキャンセルしました');
  }
}
