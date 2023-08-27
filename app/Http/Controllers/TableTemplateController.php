<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\TableTemplate;
use Inertia\Inertia;

class TableTemplateController extends Controller
{
    public function index() {
        $tableTemplates = TableTemplate::where('user_id', auth()->user()->id)->get();
        $tableTemplates->map(function ($tableTemplate) {
            $tableTemplate->column_data = json_decode($tableTemplate->column_data);
            $tableTemplate->row_data = json_decode($tableTemplate->row_data);

            return $tableTemplate;
        });

        return Inertia::render('Dashboard', [
            'tableTemplates' => $tableTemplates
        ]);
    }
    public function store(Request $request) {
        $tableTemplate = new TableTemplate();
        $tableTemplate->user_id = auth()->user()->id;
        $tableTemplate->column_data = json_encode($request->columnNames);
        $tableTemplate->row_data = json_encode($request->rowNames);
        $tableTemplate->save();

        return redirect()->route('table-template.index');
    }
}
