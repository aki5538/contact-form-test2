@extends('layouts.app') {{-- 共通レイアウトを継承 --}}

@section('content')
<div class="register-container">
    <h1>FashionablyLate</h1>
    <h2>Register</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf
    <label>お名前</label>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror

    <label>メールアドレス</label>
    <input type="email" name="email" value="{{ old('email') }}">
    @error('email')
        <div style="color: red;">{{ $message }}</div>
    @enderror

    <label>パスワード</label>
    <input type="password" name="password" required>
    
    @error('password')
        <div style="color: red;">{{ $message }}</div>
    @enderror

    <button type="submit">登録</button>
</form>