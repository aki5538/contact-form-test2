@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form">
    <h1 class="contact-title">Contact</h1>
    <form action="{{ route('contact.confirm') }}" method="POST">
        @csrf
        <label for="name">お名前 <span class="required">※</span></label>
        <div class="name-group">
            <label for="last_name">姓 <span class="required">※</span></label>
            <input type="text" id="last_name" name="last_name" placeholder="例：山田">

            <label for="first_name">名 <span class="required">※</span></label>
            <input type="text" id="first_name" name="first_name" placeholder="例：太郎">
        </div>
        @error('last_name')
            <div class="error">{{ $message }}</div>
        @enderror
        @error('first_name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="gender">性別<span class="required">※</span></label>
        <select name="gender" id="gender">
            <option value="">性別を選択してください</option>
            <option value="1" {{ old('gender') == 1 ? 'selected' : '' }}>男性</option>
            <option value="2" {{ old('gender') == 2 ? 'selected' : '' }}>女性</option>
            <option value="3" {{ old('gender') == 3 ? 'selected' : '' }}>その他</option>
        </select>
        @error('gender')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="email">メールアドレス <span class="required">※</span></label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="例: sample@example.com">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="tel">電話番号 <span class="required">※</span></label>
        <div class="tel-group">
            <input type="text" id="tel" name="tel1" maxlength="4" placeholder="090">
            <span class="tel-dash">ー</span>
            <input type="text" name="tel2" maxlength="4" placeholder="1234">
            <span class="tel-dash">ー</span>
            <input type="text" name="tel3" maxlength="4" placeholder="5678">
            <input type="hidden" name="tel" value="{{ old('tel1') }}-{{ old('tel2') }}-{{ old('tel3') }}">
        </div>
        @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
            <div class="error">電話番号を入力してください</div>
        @endif

        <label for="address">住所 <span class="required">※</span></label>
        <input type="text" name="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3">
        @error('address')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="building">建物名</label>
        <input type="text" id="building" name="building" value="{{ old('building') }}" placeholder="例: サンライズマンション203">

        <label for="category_id">お問い合わせの種類<span class="required">※</span></label>
        <select name="category_id" id="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="content">お問い合わせ内容<span class="required">※</span></label>
        <textarea id="content" name="content" rows="5" placeholder="お問い合わせ内容を入力してください">{{ old('content') }}</textarea>
        @error('content')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">確認画面へ</button>
    </form>
    
    <!-- モーダル起動ボタン -->
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#infoModal">
    詳細を見る
    </button>

    <!-- モーダル本体 -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">詳細情報</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                ここにモーダルの内容を記述します。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

