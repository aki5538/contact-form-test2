@extends('layouts.app')

@section('title', 'お問い合わせ完了')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <div class="thanks-message">
        <h1>お問い合わせありがとうございました</h1>

        <form method="GET" action="{{ route('contact') }}">
            <button type="submit">HOME</button>
        </form>
    </div>
@endsection