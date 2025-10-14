@extends('layouts.app')

@section('title', 'お問い合わせフォーム')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<h1>お問い合わせ</h1>

@if ($errors->any())
<div class="error-box">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('contact.confirm') }}">
    @csrf

    @if($errors->any())
        <pre>{{ var_export($errors->all(), true) }}</pre>
    @endif

    <div class="form-group">
        <label for="last_name">姓 <span class="required">※</span></label>
        <input type="text" name="last_name" id="last_name" value="{{ request()->input('last_name') }}">
        @error('last_name') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="first_name">名 <span class="required">※</span></label>
        <input type="text" name="first_name" id="first_name" value="{{ request()->input('first_name') }}">
        @error('first_name') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label>性別 <span class="required">※</span></label>
        <label><input type="radio" name="gender" value="0" {{ request()->input('gender') === '0' ? 'checked' : '' }}> 男性</label>
        <label><input type="radio" name="gender" value="1" {{ request()->input('gender') === '1' ? 'checked' : '' }}> 女性</label>
        <label><input type="radio" name="gender" value="2" {{ request()->input('gender') === '2' ? 'checked' : '' }}> その他</label>
        @error('gender') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="email">メールアドレス <span class="required">※</span></label>
        <input type="email" name="email" id="email" value="{{ request()->input('email') }}">
        @error('email') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="tel">電話番号 <span class="required">※</span></label>
        <input type="text" name="tel" id="tel" value="{{ request()->input('tel') }}">
        @error('tel') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="address">住所 <span class="required">※</span></label>
        <input type="text" name="address" id="address" value="{{ request()->input('address') }}">
        @error('address') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="building">建物名</label>
        <input type="text" name="building" id="building" value="{{ request()->input('building') }}">
    </div>

    <div class="form-group">
        <label for="category_id">お問い合わせの種類 <span class="required">※</span></label>
        <select name="category_id" id="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request()->input('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
        <label for="message">お問い合わせ内容 <span class="required">※</span></label>
        <textarea name="message" id="message" maxlength="120">{{ request()->input('message') }}</textarea>
        @error('message') <p class="error">{{ $message }}</p> @enderror
    </div>

    <button type="submit">確認画面へ</button>
</form>
@endsection