<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ContactController extends Controller
{
    public function admin()
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        $csvData = Contact::all(); // エクスポート用

        return view('admin', compact('contacts', 'categories', 'csvData'));
    }

    public function index()
    {
        $categories = Category::all(); // セレクトボックス用
        return view('contact', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $inputs = $request->all();

        // 性別のラベル変換
        $genderLabels = ['0' => '男性', '1' => '女性', '2' => 'その他'];
        $inputs['gender_label'] = $genderLabels[$inputs['gender']] ?? '未設定';

        // カテゴリ名の取得
        $category = Category::find($inputs['category_id']);
        $inputs['category_name'] = $category ? $category->name : '未選択';

        return view('confirm', compact('inputs'));
    }

    public function destroy(Request $request)
    {
        $contact = Contact::find($request->id);

        if ($contact) {
            $contact->delete();
        }

        return redirect()->route('search')->with('message', '削除しました');
    }

     // 🔹 検索一覧表示
    public function search(Request $request)
    {
        $query = $this->getSearchQuery($request, Contact::query());
        $contacts = $query->paginate(7);
        return view('admin', compact('contacts'));
    }

     // 🔹 CSVエクスポート
    public function export(Request $request)
    {
        $query = $this->getSearchQuery($request, Contact::query());
        $contacts = $query->get();

        $csvHeader = ['ID', '姓', '名', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせ内容'];
        $csvData = $contacts->map(function ($contact) {
            return [
                $contact->id,
                $contact->last_name,
                $contact->first_name,
                $contact->gender == 0 ? '男性' : ($contact->gender == 1 ? '女性' : 'その他'),
                $contact->email,
                $contact->tell,
                $contact->address,
                $contact->building,
                $contact->message,
            ];
        });

        $filename = 'contacts_export_' . now()->format('Ymd_His') . '.csv';
        return Response::stream(function () use ($csvHeader, $csvData) {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, $csvHeader);
            foreach ($csvData as $row) {
                fputcsv($stream, $row);
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

     // 🔹 共通検索処理（責務分離）
    private function getSearchQuery(Request $request, $query)
    {
        if (!empty($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->name . '%');
            });
        }

        if (!empty($request->gender)) {
            $query->where('gender', $request->gender);
        }

        return $query;
    }
}







