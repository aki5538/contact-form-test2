@extends('layouts.app')

@section('title', 'お問い合わせ内容の確認')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<h1>内容確認</h1>

<form method="POST" action="{{ route('contact.store') }}">
    @csrf

    <table class="confirm-table">
        <tr>
            <th>姓</th>
            <td>{{ $inputs['last_name'] }}</td>
        </tr>
        <tr>
            <th>名</th>
            <td>{{ $inputs['first_name'] }}</td>
        </tr>
        <tr>
            <th>性別</th>
            <td>
                @php
                    $gender = ['男性', '女性', 'その他'];
                @endphp
                {{ $gender[$inputs['gender']] ?? '未選択' }}
            </td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $inputs['email'] }}</td>
        </tr>
        <tr>
            <th>電話番号</th>
            <td>{{ $inputs['tel1'] }}-{{ $inputs['tel2'] }}-{{ $inputs['tel3'] }}</td>
        </tr>
        <tr>
            <th>住所</th>
            <td>{{ $inputs['address'] }}</td>
        </tr>
        <tr>
            <th>建物名</th>
            <td>{{ $inputs['building'] }}</td>
        </tr>
        <tr>
            <th>お問い合わせの種類</th>
            <td>{{ $inputs['category_name'] ?? '未選択' }}</td>
        </tr>
        <tr>
            <th>お問い合わせ内容</th>
            <td>{{ $inputs['message'] }}</td>
        </tr>
    </table>

    @foreach($inputs as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach

    <div class="button-group">
        <button type="submit" formaction="{{ route('contact.form') }}">修正する</button>
        <button type="submit">送信する</button>
    </div>
</form>
@endsection