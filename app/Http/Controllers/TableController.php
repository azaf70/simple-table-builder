<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\TableTemplate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TableController extends Controller
{

    public function index()
    {
//        $tableData = Table::with('columns')->withWhereHas('columns.rows')->where('user_id', auth()->user()->id)->get();
//        $tableData = $tableData->map(function ($table) {
//            $table->columns = $table->columns->map(function ($column) {
//                $column->rows = $column->rows->map(function ($row) {
//                    return [
//                        'value' => $row->value,
//                    ];
//                });
//                return [
//                    'name' => $column->name,
//                    'rows' => $column->rows,
//                ];
//            });
//            return [
//                'name' => $table->name,
//                'columns' => $table->columns,
//            ];
//        });

        $tableData = Table::where('user_id', auth()->user()->id)->get();

        return Inertia::render('Dashboard', [
            'tableData' => $tableData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        //
    }
}
