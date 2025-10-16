<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;


class ContactController extends Controller
{
    // トップページ
    public function index()
    {
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    // 入力画面（初回表示）
    public function create()
    {
        return view('contact');
    }

    // 確認画面から戻る（入力値を復元）
    public function form(Request $request)
    {
        return view('contact')->withInput();
    }

    // 確認画面の表示（バリデーション含む）
    public function confirm(ContactRequest $request)
    {
        $inputs = $request->all();
        return view('contact.confirm', compact('inputs'));
    }

    // 保存処理 → 完了画面
    public function store(ContactRequest $request)
    {
        $inputs = $request->all();

        Contact::create([
            'last_name' => $inputs['last_name'],
            'first_name' => $inputs['first_name'],
            'gender' => $inputs['gender'],
            'email' => $inputs['email'],
            'tel' => $inputs['tel'],
            'address' => $inputs['address'],
            'building' => $inputs['building'] ?? null,
            'category_id' => $inputs['category_id'],
            'message' => $inputs['message'],
        ]);

        return view('contact.thanks');
    }

    // 管理画面（ログイン後）
    public function admin()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('admin.index', compact('contacts'));
    }

    // 検索機能（管理者用）
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $contacts = Contact::where('last_name', 'like', "%{$keyword}%")
            ->orWhere('first_name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->paginate(10);

        return view('admin.index', compact('contacts'));
    }

    // 削除機能（管理者用）
    public function delete(Request $request)
    {
        $id = $request->input('id');
        Contact::findOrFail($id)->delete();
        return redirect()->route('admin')->with('status', '削除しました');
    }

    // CSVエクスポート（管理者用）
    public function export()
    {
        // 実装は後で追加（Laravel Excelなど）
        return response()->download(storage_path('exports/contacts.csv'));
    }
}







