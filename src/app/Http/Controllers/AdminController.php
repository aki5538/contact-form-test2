<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 検索ロジック（前回の提案通り）
    }

    public function export(Request $request)
    {
        // CSVエクスポートロジック（前回の提案通り）
    }
}
