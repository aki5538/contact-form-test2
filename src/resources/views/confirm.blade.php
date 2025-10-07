@extends('layouts.app')

@section('title', 'お問い合わせ内容の確認')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
    <h1>お問い合わせ内容の確認</h1>

    <table class="confirm-table">
        <tr><th>お名前</th><td>{{ $inputs['last_name'] }} {{ $inputs['first_name'] }}</td></tr>
        <tr><th>性別</th><td>{{ $inputs['gender_label'] }}</td></tr>
        <tr><th>メールアドレス</th><td>{{ $inputs['email'] }}</td></tr>
        <tr><th>電話番号</th><td>{{ $inputs['tel'] }}</td></tr>
        <tr><th>住所</th><td>{{ $inputs['address'] }}</td></tr>
        <tr><th>建物名</th><td>{{ $inputs['building'] }}</td></tr>
        <tr><th>お問い合わせの種類</th><td>{{ $inputs['category_name'] }}</td></tr>
        <tr><th>お問い合わせ内容</th><td>{{ $inputs['message'] }}</td></tr>
    </table>

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf
        @foreach($inputs as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit">送信</button>
    </form>

    <form method="POST" action="{{ route('contact') }}">
        @csrf
        @foreach($inputs as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="submit">修正</button>
    </form>
@endsection