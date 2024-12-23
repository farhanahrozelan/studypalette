<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Note;

class AnalyticsController extends Controller
{
    public function getApprovalDisapprovalData(Request $request)
    {
        $query = DB::table('notes')
            ->selectRaw("DATE(updated_at) as date, status, COUNT(*) as count")
            ->whereIn('status', ['approved', 'disapproved'])
            ->groupBy(DB::raw('DATE(updated_at)'), 'status')
            ->orderBy('date', 'asc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween(DB::raw('DATE(updated_at)'), [$request->start_date, $request->end_date]);
        }

        $data = $query->get();
        return response()->json($data);
    }

    public function getUserEngagement(Request $request)
    {
        $query = DB::table('notes')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
        }

        $data = $query->get();    
        return response()->json($data);
    }
    
    /*public function getFlaggedNotesOverTime(Request $request)
    {
        $query = DB::table('flagged_notes')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc');
            
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
        }
        
        $data = $query->get();
        return response()->json($data);
    }*/

    public function getReportedNotesOverTime(Request $request)
    {
        $query = DB::table('reports')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc');
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
        }

        $data = $query->get();
        return response()->json($data);
    }

    public function getTrendingIssues(Request $request)
    {
        $query = DB::table('reports')
            ->selectRaw('DATE(created_at) as date, reason, COUNT(*) as count')
            ->whereNotNull('reason');
        
        // Apply date range filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
        }
        
        // Apply category filter
        if ($request->has('categories')) {
            $categories = explode(',', $request->categories);
            $query->whereIn('reason', $categories);
        }
        
        $data = $query->groupBy('date', 'reason')
            ->orderBy('date', 'asc')
            ->get();
            
        return response()->json($data);
    }
    
    public function getTrendingIssuesCategories()
    {
        $categories = DB::table('reports')
            ->distinct()
            ->pluck('reason');
        
        return response()->json($categories);
    }

}

