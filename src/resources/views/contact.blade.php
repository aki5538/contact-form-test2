@extends('layouts.app')

@section('title', 'お問い合わせフォーム')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<h1>お問い合わせ</h1>

@if ($errors->any())
 <div class="alert alert-danger">


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
    <div class="form-group">
        <label for="last_name">姓 <span class="required">※</span></label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}">
    </div>

    <div class="form-group">
        <label for="first_name">名 <span class="required">※</span></label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}">
    </div>

    <div class="form-group">
        <label>性別 <span class="required">※</span></label>
        <label><input type="radio" name="gender" value="0" {{ old('gender') === '0' ? 'checked' : '' }}> 男性</label>
        <label><input type="radio" name="gender" value="1" {{ old('gender') === '1' ? 'checked' : '' }}> 女性</label>
        <label><input type="radio" name="gender" value="2" {{ old('gender') === '2' ? 'checked' : '' }}> その他</label>
    </div>

    <div class="form-group">
        <label for="email">メールアドレス <span class="required">※</span></label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
    </div>

    <div class="form-group">
        <label for="tel1">電話番号 <span class="required">※</span></label>
        <input type="text" name="tel1" id="tel1" value="{{ old('tel1') }}" size="4"> -
        <input type="text" name="tel2" id="tel2" value="{{ old('tel2') }}" size="4"> -
        <input type="text" name="tel3" id="tel3" value="{{ old('tel3') }}" size="4">
    </div>

    <div class="form-group">
        <label for="address">住所 <span class="required">※</span></label>
        <input type="text" name="address" id="address" value="{{ old('address') }}">
    </div>

    <div class="form-group">
        <label for="building">建物名</label>
        <input type="text" name="building" id="building" value="{{ old('building') }}">
    </div>

    <div class="form-group">
        <label for="category_id">お問い合わせの種類 <span class="required">※</span></label>
        <select name="category_id" id="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="message">お問い合わせ内容 <span class="required">※</span></label>
        <textarea name="message" id="message" maxlength="120">{{ old('message') }}</textarea>
    </div>

    <button type="submit">確認画面へ</button>
</form>
@endsection