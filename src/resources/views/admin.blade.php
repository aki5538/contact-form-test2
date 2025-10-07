@extends('layouts.app')

@section('title', 'お問い合わせ管理')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1>お問い合わせ管理</h1>

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('admin') }}" class="search-form">
        <input type="text" name="name" value="{{ request('name') }}" placeholder="名前">
        <select name="gender">
            <option value="">性別</option>
            <option value="0" {{ request('gender') === '0' ? 'selected' : '' }}>男性</option>
            <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>女性</option>
            <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>その他</option>
        </select>
        <button type="submit">検索</button>
        <a href="{{ route('admin') }}">リセット</a>
    </form>

    {{-- 一覧表示 --}}
    <table class="contact-table">
        <thead>
            <tr>
                <th>名前</th>
                <th>メール</th>
                <th>性別</th>
                <th>カテゴリ</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->full_name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->gender_label }}</td>
                    <td>{{ $contact->category->name }}</td>
                    <td>
                        <button class="detail-button" data-id="{{ $contact->id }}">詳細</button>
                        <form method="POST" action="/delete" class="delete-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $contact->id }}">
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ページネーション --}}
    <div class="pagination">
        {{ $contacts->links() }}
    </div>

    {{-- エクスポート --}}
    <form method="GET" action="/export" class="export-form">
        <input type="hidden" name="name" value="{{ request('name') }}">
        <input type="hidden" name="gender" value="{{ request('gender') }}">
        <button type="submit">CSVエクスポート</button>
    </form>

    {{-- モーダルウィンドウ削除 --}}
    <form method="POST" action="{{ route('contact.delete') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $contact->id }}">
        <button type="submit">削除</button>
    </form>
@endsection