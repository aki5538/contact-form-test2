@extends('layouts.app')

@section('title', 'お問い合わせ管理')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .export-button {
            background-color: #8B4513;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
        }

        .export-button:hover {
            background-color: #A0522D;
        }

        .pagination-container {
            margin-left: 880px; /* ← 横の余白を追加！ */
        }

        .pagination {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')

<!-- ログアウトボタン（フォーム） -->
<form method="POST" action="{{ route('logout') }}" style="text-align: right; margin-bottom: 10px;">
    @csrf
    <button type="submit">ログアウト</button>
</form>

<h1>FashionablyLate</h1>

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('admin') }}" class="search-form">
        <input type="text" name="name" value="{{ request('name') }}" placeholder="名前">
        <input type="text" name="email" value="{{ request('email') }}" placeholder="メールアドレス">

        <select name="gender">
            <option value="">性別</option>
            <option value="0" {{ request('gender') === '0' ? 'selected' : '' }}>男性</option>
            <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>女性</option>
            <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>その他</option>
        </select>

        <select name="category_id">
            <option value="">お問い合わせの種類</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <input type="date" name="date" value="{{ request('date') }}">

        <button type="submit">検索</button>
        
        <a href="{{ route('admin') }}" class="reset-button">リセット</a>

        <div class="d-flex align-items-center mb-3">
            <button type="submit" formaction="{{ route('admin.export') }}" formmethod="GET" class="export-button">
                エクスポート
            </button>

            <div class="pagination-container">
                {{ $contacts->links('vendor.pagination.default') }}
            </div>
        </div>
    </form>

    {{-- 一覧表示 --}}
    <table class="contact-table">
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th style="background-color: #6c4c3b; color: #fff; padding: 10px;"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->full_name }}</td>
                    <td>{{ $contact->gender_label }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category->name }}</td>
                    <td>
                        <button class="btn btn-info" data-id="{{ $contact->id }}" data-toggle="modal" data-target="#contactModal">
                            詳細
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ✅ モーダルHTMLを追記！ -->
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">お問い合わせ詳細</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>お名前：</strong> <span id="modal-name"></span></p>
                    <p><strong>性別：</strong> <span id="modal-gender"></span></p>
                    <p><strong>メールアドレス：</strong> <span id="modal-email"></span></p>
                    <p><strong>電話番号：</strong> <span id="modal-tel"></span></p>
                    <p><strong>住所：</strong> <span id="modal-address"></span></p>
                    <p><strong>建物名：</strong> <span id="modal-building"></span></p>
                    <p><strong>お問い合わせの種類：</strong> <span id="modal-category"></span></p>
                    <p><strong>お問い合わせの内容：</strong> <span id="modal-message"></span></p>
                </div>
                <div class="modal-footer">
                    <form method="POST" id="delete-form">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="">
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ BootstrapのJSを読み込み！ -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ モーダルにデータを差し込むJSを追加 -->
    <script>
        const contacts = @json($contacts->toArray()['data']); // ← ページ内の配列だけを抽出！

        // 以下は詳細ボタンの処理
        document.querySelectorAll('[data-toggle="modal"]').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const contact = contacts.find(c => c.id == id);

                if (!contact) return;

                document.getElementById('modal-name').textContent = contact.last_name + ' ' + contact.first_name;
                document.getElementById('modal-gender').textContent = ['男性', '女性', 'その他'][contact.gender];
                document.getElementById('modal-email').textContent = contact.email;
                document.getElementById('modal-tel').textContent = contact.tel;
                document.getElementById('modal-address').textContent = contact.address;
                document.getElementById('modal-building').textContent = contact.building ?? '-';
                document.getElementById('modal-category').textContent = contact.category.name;
                document.getElementById('modal-message').textContent = contact.message;

                document.getElementById('delete-form').setAttribute('action', `/contacts/${id}`);
                document.querySelector('#delete-form input[name="id"]').value = id;
            });
        });
    </script>

@endsection