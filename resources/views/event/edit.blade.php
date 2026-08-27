@extends('layouts.app')

@section('title', 'Eventify - イベント編集')

@section('topbar')
<header class="top-bar">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">ダッシュボード</a>
    <span>/</span>
    <a href="{{ route('event.show', $event->id) }}">{{ Str::limit($event->title, 20) }}</a>
    <span>/</span>
    <span>編集</span>
  </div>
  <div class="top-actions">
    <a href="{{ route('event.show', $event->id) }}" class="btn btn-default">キャンセル</a>
  </div>
</header>
@endsection

@section('content')
<div class="page-header">
  <h1>イベント編集</h1>
  <p>イベントの登録情報を更新します</p>
</div>

@include('event._form', ['event' => $event, 'categories' => $categories, 'statuses' => $statuses])
@endsection
