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

    public function edit(TableTemplate $tableTemplate) {
        $tableTemplate->column_data = json_decode($tableTemplate->column_data);
        $tableTemplate->row_data = json_decode($tableTemplate->row_data);

        return Inertia::render('TableTemplate/Edit', [
            'tableTemplate' => $tableTemplate->toArray()
        ]);
    }
    public function store(Request $request) {

        //check if request is not empty
        //loop through the items
        dd($request->all());

        $data = [];
        foreach ($request->columnNames as $key => $columnName) {
            $data[] = [
                'name' => $columnName,
                'type' => $request->columnTypes[$key]
            ];
        }

        $tableTemplate = new TableTemplate();
        $tableTemplate->name = $request->name;
        $tableTemplate->user_id = auth()->user()->id;
        $tableTemplate->column_data = json_encode($data);
        $tableTemplate->save();

        return redirect()->route('table-template.index');
    }

    private function determineValidation($type) {
        return match ($type) {
            'String', 'Text' => 'required|string',
            'Email' => 'required|email',
            'Number' => 'required|numeric',
            'Date' => 'required|date',
            default => 'required',
        };
    }
}
