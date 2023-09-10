<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Table;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $table = Table::updateOrCreate(
            [
                'name' => $request->name,
            ],
            [
                'user_id' => auth()->user()->id,
            ]
        );

        $data = [];
        foreach ($request->columnNames as $key => $columnName) {
            $data[] = [
                'name' => $columnName,
                'type' => $request->columnTypes[$key],
                'validation_rules' => $request->columnValidationRules[$key]
            ];
        }
        foreach ($data as $column) {
            Column::create([
                'name' => $column['name'],
                'type' => $column['type'],
                'validation_rules' => json_encode($column['validation_rules']),
                'table_id' => $table->id,
            ]);
        }

        return redirect()->route('table.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Column $column)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Column $column)
    {
        //
    }
}
