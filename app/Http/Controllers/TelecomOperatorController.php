<?php

namespace App\Http\Controllers;

use App\Models\TelecomOperator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TelecomOperatorController extends Controller
{
    public function index()
    {
        $operators = TelecomOperator::query()
            ->orderBy('name')
            ->paginate(15);

        return response()->json($operators);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:telecom_operators,name',
            ],
            'code' => [
                'required',
                'string',
                'max:5',
                'unique:telecom_operators,code',
            ],
            'status' => [
                'sometimes',
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $operator = TelecomOperator::create($validated);

        return response()->json([
            'message' => 'Telecom operator created successfully.',
            'data' => $operator,
        ], 201);
    }

    public function show(string $id)
    {
        $operator = TelecomOperator::findOrFail($id);

        return response()->json([
            'data' => $operator,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $operator = TelecomOperator::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('telecom_operators', 'name')
                    ->ignore($operator->id),
            ],
            'code' => [
                'sometimes',
                'required',
                'string',
                'max:5',
                Rule::unique('telecom_operators', 'code')
                    ->ignore($operator->id),
            ],
            'status' => [
                'sometimes',
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $operator->update($validated);

        return response()->json([
            'message' => 'Telecom operator updated successfully.',
            'data' => $operator->fresh(),
        ]);
    }

    public function destroy(string $id)
    {
        $operator = TelecomOperator::findOrFail($id);

        if ($operator->phoneNumbers()->exists()) {
            return response()->json([
                'message' => 'Cannot delete a telecom operator that has phone numbers.',
            ], 409);
        }

        $operator->delete();

        return response()->json([
            'message' => 'Telecom operator deleted successfully.',
        ]);
    }
}
