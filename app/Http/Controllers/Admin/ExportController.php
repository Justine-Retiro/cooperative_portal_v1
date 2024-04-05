<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoansExport;
use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExportController extends Controller
{

    public function index(){
        return view('admin.partials.export');
    }

    public function export(Request $request)
    {
        $exportType = $request->input('export_type');
        $selectedFields = $request->input('selected_fields', []);
        $filters = [];
        if ($exportType == 'quick') {
            $quickExportOption = $request->input('quickExportOption');
            if ($quickExportOption == 'custom') {
                // Exclude non-filter inputs
                $inputFields = collect($request->except(['_token', 'export_type', 'quickExportOption', 'selected_fields']))
                    ->filter(function ($value, $key) {
                        return strpos($key, '_filter_type') !== false || strpos($key, '_operator') !== false || strpos($key, '_value') !== false || strpos($key, '_from') !== false || strpos($key, '_to') !== false;
                    });

                // Dynamically build filters from request inputs
                foreach ($inputFields as $key => $value) {
                    // Extract the base field name by removing the filter suffix
                    $baseFieldName = preg_replace('/(_filter_type|_operator|_value|_from|_to)$/', '', $key);
                    if (!isset($filters[$baseFieldName])) {
                        $filters[$baseFieldName] = [];
                    }
                    // Map the input to the correct filter property
                    if (strpos($key, '_filter_type') !== false) {
                        $filters[$baseFieldName]['fieldOption'] = $value;
                    } elseif (strpos($key, '_operator') !== false) {
                        $filters[$baseFieldName]['operator'] = $value;
                    } elseif (strpos($key, '_value') !== false) {
                        $filters[$baseFieldName]['value'] = $value;
                    } elseif (strpos($key, '_from') !== false) {
                        if (strpos($baseFieldName, '_date') !== false) {
                            $filters[$baseFieldName]['from'] = $value ? Carbon::parse($value)->startOfDay() : null;
                        } else {
                            $filters[$baseFieldName]['from'] = $value;
                        }
                    } elseif (strpos($key, '_to') !== false) {
                        if (strpos($baseFieldName, '_date') !== false) {
                            $filters[$baseFieldName]['to'] = $value ? Carbon::parse($value)->endOfDay() : null;
                        } else {
                            $filters[$baseFieldName]['to'] = $value;
                        }
                    }
                }
                $filteredData = $this->exportFetchedFilteredDataForQuickExport($filters);
                $fileName = 'loans_quick_custom_export.xlsx';
                $export = new LoansExport($exportType, $selectedFields, $filters, $filteredData);
                return Excel::download($export, $fileName);
            } else {
                // Quick default export
                return Excel::download(new LoansExport($exportType), 'loans_quick_default_export.xlsx');
            }
        } else {
            $options = []; // Initialize an empty array to hold field options
            foreach ($selectedFields as $field) {
                // Capture the input for each field
                $fieldOptions = [
                    'operator' => $request->input($field . '_operator', null), // Default to null if not provided
                    'value' => $request->input($field . '_value', null), // Default to null if not provided
                    'from' => $request->input($field . '_from', null), // Default to null if not provided
                    'to' => $request->input($field . '_to', null), // Default to null if not provided
                ];
    
                // Filter out null values to avoid processing them later
                $options[$field] = array_filter($fieldOptions, function($value) {
                    return !is_null($value);
                });
            }
    
            return Excel::download(new LoansExport($exportType, $selectedFields, $options), 'loans_custom_export.xlsx');
        }
    }
    public function exportFetchedFilteredDataForQuickExport(array $filters)
    {
        $query = LoanApplication::query()->with('user:id,account_number');
        // \Log::info('Formatted Filters: ', $filters);
        foreach ($filters as $field => $options) {
            $filterType = $options['fieldOption'] ?? null;
            $operator = $options['operator'] ?? null;
            $value = $options['value'] ?? null;
            $from = $options['from'] ?? null;
            $to = $options['to'] ?? null;
            if ($field === 'account_number') {
                $query->whereHas('user', function ($subQuery) use ($operator, $value) {
                    if ($operator && $value !== null) {
                        $subQuery->where('account_number', $operator, $value);
                    } elseif ($value !== null) {
                        $subQuery->where('account_number', '=', $value);
                    }
                });
            } elseif ($filterType == 'range_based' && $from && $to) {
                if (strpos($field, '_date') !== false) {
                    $query->whereBetween($field, [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()]);
                } else {
                    $query->whereBetween($field, [$from, $to]);
                }
            } elseif ($filterType == 'operator_based' && $operator) {
                if ($operator == '==') {
                    $query->where($field, $value);
                } elseif ($operator == '<=') {
                    $query->where($field, '<=', $value ?? $to);
                } elseif ($operator == '>=') {
                    $query->where($field, '>=', $value ?? $from);
                }
            } elseif ($value !== null && $operator === null) {
                // This handles simple text input filters without specific operators
                $query->where($field, '=', $value);
            }
        }    
        // \Log::info('Applying Filters:', $filters);

        $filteredData = $query->get()->makeHidden(['applicant_sign', 'applicant_receipt', 'note','created_at', 'updated_at', 'deleted_at', 'account_number_id', 'client_id', 'take_action_by_id', 'user'])
        ->map(function ($loanApplication, $index) {
            $loanApplicationArray = $loanApplication->toArray();
            $loanApplicationArray['id'] = $index + 1;
            // Insert 'account_number' after 'loan_reference'
            $position = array_search('loan_reference', array_keys($loanApplicationArray)) + 1;
            $loanApplicationArray = array_slice($loanApplicationArray, 0, $position, true) +
                                    ['account_number' => $loanApplication->user->account_number] +
                                    array_slice($loanApplicationArray, $position, null, true);
            return $loanApplicationArray;
        });



        return $filteredData;
    }
    public function fetchFilteredDataForQuickExport(Request $request)
    {
        $filters = $request->input('filters', []);

        $query = LoanApplication::query()->with('user:id,account_number');
        
        // \Log::info('Preview of Formatted Filters: ', $filters);

        foreach ($filters as $field => $options) {
            $filterType = $options['fieldOption'] ?? null;
            $operator = $options['operator'] ?? null;
            $value = $options['value'] ?? null;
            $from = $options['from'] ?? null;
            $to = $options['to'] ?? null;

            if ($field === 'account_number') {
                $query->whereHas('user', function ($subQuery) use ($operator, $value) {
                    if ($operator && $value !== null) {
                        $subQuery->where('account_number', $operator, $value);
                    } elseif ($value !== null) {
                        $subQuery->where('account_number', '=', $value);
                    }
                });
            } elseif ($filterType == 'range_based' && $from && $to) {
                if (strpos($field, '_date') !== false) {
                    $query->whereBetween($field, [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()]);
                } else {
                    $query->whereBetween($field, [$from, $to]);
                }
            } elseif ($filterType == 'operator_based' && $operator && $value !== null) {
                switch ($operator) {
                    case '==':
                        $query->where($field, $value);
                        break;
                    case '<=':
                        $query->where($field, '<=', $value);
                        break;
                    case '>=':
                        $query->where($field, '>=', $value);
                        break;
                }
            } elseif ($value !== null && $operator === null) {
                $query->where($field, '=', $value);
            }
        }

        $filteredData = $query->get()->makeHidden(['applicant_sign', 'applicant_receipt', 'note','created_at', 'updated_at', 'deleted_at', 'account_number_id', 'client_id', 'take_action_by_id', 'user'])
        ->map(function ($loanApplication, $index) {
            $loanApplicationArray = $loanApplication->toArray();
            $loanApplicationArray['id'] = $index + 1;
            // Insert 'account_number' after 'loan_reference'
            $position = array_search('loan_reference', array_keys($loanApplicationArray)) + 1;
            $loanApplicationArray = array_slice($loanApplicationArray, 0, $position, true) +
                                    ['account_number' => $loanApplication->user->account_number] +
                                    array_slice($loanApplicationArray, $position, null, true);
            return $loanApplicationArray;
        });


        return $filteredData;
    }

    public function fetchFilteredData(Request $request)
    {
        $filters = $request->input('filters', []);
        $query = LoanApplication::query();

        foreach ($filters as $field => $options) {
            $filterType = $options['fieldOption'] ?? null;
            $operator = $options['operator'] ?? null;
            $value = $options['value'] ?? null;
            $from = $options['from'] ?? null;
            $to = $options['to'] ?? null;

            if ($field === 'account_number') {
                $query->whereHas('user', function ($subQuery) use ($operator, $value) {
                    if ($operator && $value !== null) {
                        $subQuery->where('account_number', $operator, $value);
                    } elseif ($value !== null) {
                        $subQuery->where('account_number', '=', $value);
                    }
                });
            } elseif ($filterType == 'range_based' && $from && $to) {
                $query->whereBetween($field, [$from, $to]);
            } elseif ($filterType == 'operator_based' && $operator && $value !== null) {
                $query->where($field, $operator, $value);
            } elseif ($value !== null && $operator === null) {
                $query->where($field, '=', $value);
            }
        }

        $filteredData = $query->get()->makeHidden(['applicant_sign', 'applicant_receipt']);

        return response()->json($filteredData);
    }

    public function updateRowPosition(Request $request)
    {
        $order = $request->input('order');
        $positions = explode(',', $order);

        // Store the updated positions in the session
        $fieldPositions = [];
        foreach ($positions as $index => $fieldName) {
            $fieldPositions[$fieldName] = $index;
        }
        session(['field_positions' => $fieldPositions]);

        return response()->json(['success' => true]);
    }
    private function applyFilters($query, $filters)
    {
        foreach ($filters as $field => $options) {
            $filterType = $options['filter_type'] ?? null;
            $operator = $options['operator'] ?? null;
            $value = $options['value'] ?? null;
            $from = $options['from'] ?? null;
            $to = $options['to'] ?? null;

            if ($filterType == 'range_based' && $from && $to) {
                $query->whereBetween($field, [$from, $to]);
            } elseif ($filterType == 'operator_based' && $operator && $value !== null) {
                switch ($operator) {
                    case '==':
                        $query->where($field, $value);
                        break;
                    case '<=':
                        $query->where($field, '<=', $value);
                        break;
                    case '>=':
                        $query->where($field, '>=', $value);
                        break;
                }
            } elseif ($value !== null && $operator === null) {
                // This handles simple text input filters without specific operators
                // Adjust the logic as needed, e.g., using 'like' for partial matches
                $query->where($field, 'like', '%' . $value . '%');
            }
        }
    }
}