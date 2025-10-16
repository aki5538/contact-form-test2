@extends('layouts.app')

@section('title', 'お問い合わせ完了')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <h1>お問い合わせありがとうございます</h1>

    <div class="button-group">
        <a href="{{ route('contact.form') }}">お問い合わせフォームに戻る</a>
        <a href="{{ url('/') }}">トップページへ</a>
    </div>
@endsection