@extends('layouts.app') {{-- レイアウトがある場合 --}}
@section('content')

<h2>ログイン</h2>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="email">メールアドレス</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <p style="color: red;">{{ $message }}</p>
    @enderror

    <label for="password">パスワード</label>
    <input type="password" name="password" required>
    @error('password')
        <p style="color: red;">{{ $message }}</p>
    @enderror

    <button type="submit">ログイン</button>
</form>

<p><a href="{{ route('register') }}">register</a></p>

@endsection