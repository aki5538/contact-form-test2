<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Contact;
use App\Models\Category;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();
        // 検索条件がある場合はここで絞り込み（省略）

        $contacts = $query->paginate(3); // ✅ 7件ずつ表示
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    public function admin(Request $request)
    {
        // 絞り込みやページネーション付きの一覧
        $contacts = Contact::with('category')
            ->where(...) // ← 絞り込み条件があればここ
            ->paginate(7);

        // ✅ モーダル用：全件取得（JSON化用）
        $allContacts = Contact::with('category')->get();

        return view('admin', [
            'contacts' => $contacts,
            'allContacts' => $allContacts, // ← これをBladeに渡す！
        ]);


    }

    public function export(Request $request)
    {
         // 🔸 検索条件付きのクエリを構築
        $query = \App\Models\Contact::with('category');

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('last_name', 'like', '%' . $request->name . '%')
                    ->orWhere('first_name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('gender')) {
            $genderMap = ['男性', '女性', 'その他'];
            $query->where('gender', $genderMap[(int) $request->gender]);
        }

        // 🔸 絞り込んだ結果を取得
        $contacts = $query->get();

        $csvHeader = ['ID', '名前', '性別', 'メール', '電話', '住所', '建物名', '種別', '内容'];
        $csvData = $contacts->map(function ($contact) {
            return [
                $contact->id,
                $contact->last_name . ' ' . $contact->first_name,
                ['男性', '女性', 'その他'][$contact->gender],
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->name ?? '-',
                $contact->message,
            ];
        });

        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        // ✅ Excelで文字化けしないようにShift-JISに変換（日本語環境向け）
        $csvContent = mb_convert_encoding($csvContent, 'SJIS-win', 'UTF-8');

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
