<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        $auditLogs = AuditLog::all();
        return view('admin.audit.audit', compact('auditLogs'));
    }

    public function fetchRecords(Request $request)
    {
        $order = $request->input('order', 'asc'); // Default to 'asc' if not provided

        $auditLogs = AuditLog::orderBy('created_at', $order)->paginate(20);

        $totalRecords = $auditLogs->total();
        $recordsPerPage = $auditLogs->perPage();
        $currentPageCount = $auditLogs->count();

        if ($request->ajax()) {
            $paginationView = $totalRecords > $recordsPerPage ? 'pagination::bootstrap-5' : 'admin.repositories.partials.pagination';

            $paginationHtml = $totalRecords > $recordsPerPage ?
                $auditLogs->appends([
                    'order' => $order,
                ])->links($paginationView)->toHtml() :
                view($paginationView, [
                    'count' => $currentPageCount,
                    'total' => $totalRecords,
                    'perPage' => $recordsPerPage,
                    'currentPage' => $auditLogs->currentPage(),
                ])->render();

            return response()->json([
                'html' => view('admin.audit.partials.audit-table', compact('auditLogs'))->render(),
                'pagination' => $paginationHtml,
            ]);
        }

        // Return a default view or response for non-AJAX requests
        return view('admin.audit.index', compact('auditLogs'));
    }
}