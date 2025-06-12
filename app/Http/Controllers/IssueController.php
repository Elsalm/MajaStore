<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'type' => 'required|in:product,otro',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $issue = Issue::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'type' => $request->type,
            'product_id' => $request->type === 'product' ? $request->product_id : null,
        ]);

        return response()->json([
            'model' => 'issues',
            'data' => [
                'id' => $issue->id,
                'description' => $issue->description,
                'type' => $issue->type,
                'product_id' => $issue->product_id,
                'user' => [
                    'id' => $issue->user->id,
                    'email' => $issue->user->email,
                ],
                'created_at' => $issue->created_at,
            ],
        ], 201);
    }

    public function getAll()
    {
        $issues = Issue::with('user:id,email')->get();

        return response()->json([
            'model' => 'issues',
            'data' => $issues->map(fn ($issue) => [
                'id' => $issue->id,
                'description' => $issue->description,
                'type' => $issue->type,
                'product_id' => $issue->product_id,
                'status' => $issue->status,
                'user' => [
                    'id' => $issue->user->id,
                    'email' => $issue->user->email,
                ],
                'created_at' => $issue->created_at,
            ]),
        ]);
    }

    public function destroy($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->delete();

        return response()->json(['message' => 'problema eliminado correctamente']);
    }

    public function resolve($id)
    {
        $issue = Issue::findOrFail($id);
        $issue->status = 1;
        $issue->save();

        return response()->json(['message' => 'Issue marked as resolved']);
    }
}
