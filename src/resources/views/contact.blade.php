@extends('layouts.app')

@section('title', 'お問い合わせフォーム')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
    <h1>お問い合わせ</h1>

    <form method="POST" action="{{ route('contact.post') }}" class="contact-form">
        @csrf
        {{-- お名前（姓） --}}
        <div class="form-group">
            <label for="last_name">姓 <span class="required">※</span></label>
            <input type="text" name="last_name" value="{{ old('last_name') }}">
            @error('last_name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- お名前（名） --}}
        <div class="form-group">
            <label for="first_name">名 <span class="required">※</span></label>
            <input type="text" name="first_name" value="{{ old('first_name') }}">
            @error('first_name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 性別 --}}
        <div class="form-group">
            <label>性別 <span class="required">※</span></label>
            <label><input type="radio" name="gender" value="0" {{ old('gender') === '0' ? 'checked' : '' }}> 男性</label>
            <label><input type="radio" name="gender" value="1" {{ old('gender') === '1' ? 'checked' : '' }}> 女性</label>
            <label><input type="radio" name="gender" value="2" {{ old('gender') === '2' ? 'checked' : '' }}> その他</label>
            @error('gender')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- メールアドレス --}}
        <div class="form-group">
            <label for="email">メールアドレス <span class="required">※</span></label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 電話番号 --}}
        <div class="form-group">
            <label for="tel">電話番号 <span class="required">※</span></label>
            <input type="text" name="tel" value="{{ old('tel') }}">
            @error('tel')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label for="address">住所 <span class="required">※</span></label>
            <input type="text" name="address" value="{{ old('address') }}">
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名（任意） --}}
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" value="{{ old('building') }}">
        </div>

        {{-- お問い合わせの種類 --}}
        <div class="form-group">
            <label for="category_id">お問い合わせの種類 <span class="required">※</span></label>
            <select name="category_id">
                <option value="">選択してください</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- お問い合わせ内容 --}}
        <div class="form-group">
            <label for="message">お問い合わせ内容 <span class="required">※</span></label>
            <textarea name="message" maxlength="120">{{ old('message') }}</textarea>
            @error('message')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">確認画面へ</button>
    </form>
@endsection