@extends('layouts.app')

@section('title', 'Eventify - イベント新規登録')

@section('topbar')
<header class="top-bar">
  <div class="breadcrumb">
    <a href="{{ route('home') }}">ダッシュボード</a>
    <span>/</span>
    <span>イベント新規登録</span>
  </div>
  <div class="top-actions">
    <a href="{{ route('home') }}" class="btn btn-default">キャンセル</a>
  </div>
</header>
@endsection

@section('content')
<div class="page-header">
  <h1>イベント新規登録</h1>
  <p>新しいイベント情報を入力してリストに追加します</p>
</div>

@include('event._form', ['categories' => $categories, 'statuses' => $statuses])
@endsection
