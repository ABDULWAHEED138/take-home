<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function search(Request $request)
    {

        try {
            $request->validate([
                'title'        => 'string|max:255',
                'category'     => 'array|max:50',
                'source'       => 'array|max:50',
                'publish_date' => 'date'
            ]);

            $articleQuery = Article::query();

            if ($request->has('category')) {
                $articleQuery->whereIn('category_id', $request->input('category'));
            }

            if ($request->has('source')) {
                $articleQuery->whereIn('source_id', $request->input('source'));
            }

            if ($request->has('title')) {
                $articleQuery->where('title', 'like', '%' . $request->string('title') . '%');
            }

            if ($request->has('publish_date')) {
                $articleQuery->whereDate('publish_at', $request->input('publish_date'));
            }

            $articles = $articleQuery->paginate(10);

            return response()->json($articles);
        } catch (Exception $e) {
            Log::error('Error in article/search api: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }


    }
}
