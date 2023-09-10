<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Row;
use App\Models\Table;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Table $table)
    {
        $columns = Column::where('table_id', $table->id)->get();

        return Inertia::render('Table/Rows/Create', [
            'columns' => $columns->toArray(),
            'tableData' => [
                'id' => $table->id,
                'name' => $table->name
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach ($request->items as $index => $item) {
            $rules['items.' . $index . '.value'] = $request->items[$index]['validation_rule'];
        }
        //validate with messages
        $request->validate($rules, [
            'items.*.value.required' => 'The :attribute field is required.',
            'items.*.value.string' => 'The :attribute field must be a string.',
            'items.*.value.max' => 'The :attribute field must be less than :max characters.',
            'items.*.value.min' => 'The :attribute field must be at least :min characters.',
            'items.*.value.email' => 'The :attribute field must be a valid email address.',
            'items.*.value.unique' => 'The :attribute field must be unique.',
        ], [
            'items.*.value' => 'value',
        ]);

        foreach ($request->items as $index => $item) {
            $row = new Row();
            $row->table_id = $request->table_id;
            $row->column_id = $item['column_id'];
            $row->value = $item['value'];
            $row->save();
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Row $row)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Row $row)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Row $row)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Row $row)
    {
        //
    }
}
