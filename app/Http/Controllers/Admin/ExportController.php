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

        // \Log::info('Received data:', $request->all());

        try {
            $quickExportOption = $request->input('quickExportOption');
            $selectedFields = $request->input('selected_fields', []);
    
            $filters = $request->input('filters', []);
            $exportType = $request->input('export_type');
    
            if (empty($exportType)) {
                session()->flash('error', 'Export type is required.');
                return back();
            }
    
            $selectedFields = $request->input('selected_fields', []);
            if (empty($selectedFields) && $exportType != 'quick') {
                session()->flash('error', 'Selected fields are required for custom export.');
                return back();
            }
    
            if ($exportType == 'quick') {
                $quickExportOption = $request->input('quickExportOption');
                if ($quickExportOption == 'custom') {
                    $inputFields = collect($request->except(['_token', 'export_type', 'quickExportOption', 'selected_fields']))
                        ->filter(function ($value, $key) {
                            return strpos($key, '_filter_type') !== false || strpos($key, '_operator') !== false || strpos($key, '_value') !== false || strpos($key, '_from') !== false || strpos($key, '_to') !== false;
                        });
    
                    if (empty($selectedFields)) {
                        session()->flash('error', 'No fields selected for custom export.');
                        return back();
                    }
    
                    // Add loan_type_value to the filters array if it exists
                    if ($request->has('loan_type_value')) {
                        $filters['loan_type'] = [
                            'value' => $request->input('loan_type_value'),
                        ];
                    } elseif ($request->has('remarks_value')) {
                        $filters['remarks'] = [
                            'value' => $request->input('remarks_value'),
                        ];
                    } elseif ($request->has('application_status_value')) {
                        $filters['application_status'] = [
                            'value' => $request->input('application_status_value'),
                        ];
                    }
    
                    foreach ($inputFields as $key => $value) {
                        $baseFieldName = preg_replace('/(_filter_type|_operator|_value|_from|_to)$/', '', $key);
                        if (!isset($filters[$baseFieldName])) {
                            $filters[$baseFieldName] = [];
                        }
                        if (strpos($key, '_filter_type') !== false) {
                            $filters[$baseFieldName]['fieldOption'] = $value;
                        } elseif (strpos($key, '_operator') !== false) {
                            $filters[$baseFieldName]['operator'] = $value;
                        } elseif (strpos($key, '_value') !== false) {
                            $filters[$baseFieldName]['value'] = $value;
                        } elseif (strpos($key, '_from') !== false) {
                            $filters[$baseFieldName]['from'] = $value ? Carbon::parse($value)->startOfDay() : null;
                        } elseif (strpos($key, '_to') !== false) {
                            $filters[$baseFieldName]['to'] = $value ? Carbon::parse($value)->endOfDay() : null;
                        }
                    }
                    // \Log::info('Filters before passing to exportFetchedFilteredDataForQuickExport:', $filters);
                    $filteredData = $this->exportFetchedFilteredDataForQuickExport($filters);
                    $fileName = 'loan_export.xlsx';
                    $export = new LoansExport($exportType, $selectedFields, $filters, $filteredData, $quickExportOption);
                    return Excel::download($export, $fileName);
                } else {
                    return Excel::download(new LoansExport($exportType, [], [], null, $quickExportOption), 'loan_export.xlsx');
                }
            } else {
                //  _______________________ Working ____________________________ //
                // $options = []; // Initialize an empty array to hold field options
                // foreach ($selectedFields as $field) {
                //     // Capture the input for each field
                //     $fieldOptions = [
                //         'operator' => (array) $request->input($field . '_operator', []), // Cast to array if not provided
                //         'value' => (array) $request->input($field . '_value', []), // Cast to array if not provided
                //         'from' => (array) $request->input($field . '_from', []), // Cast to array if not provided
                //         'to' => (array) $request->input($field . '_to', []), // Cast to array if not provided
                //     ];

                //     // Store field options only if they are not empty
                //     if (!empty(array_filter($fieldOptions))) {
                //         $options[$field] = $fieldOptions;
                //     }
                // }

                // return Excel::download(new LoansExport($exportType, $selectedFields, $options), 'loans_custom_export.xlsx');

                // ______________________ End Working __________________________ //

                $options = []; // Initialize an empty array to hold field options
                foreach ($selectedFields as $field) {
                    // Capture the input for each field
                    $fieldOptions = [
                        'fieldOption' => (array) $request->input($field . '_filter_type', []),
                        'operator' => (array) $request->input($field . '_operator', []),
                        'value' => (array) $request->input($field . '_value', []),
                        'from' => (array) $request->input($field . '_from', []),
                        'to' => (array) $request->input($field . '_to', []),
                    ];
            
                    // Store field options only if they are not empty
                    if (!empty(array_filter($fieldOptions))) {
                        $options[$field] = $fieldOptions;
                    }
                }
            
                return Excel::download(new LoansExport($exportType, $selectedFields, $options), 'loans_custom_export.xlsx');



                // $filters = $data['filters'] ?? [];
                // \Log::info('Selected Fields:', $selectedFields);
                // \Log::info('Filters applied:', $filters);
                // $filters = [];
                // foreach ($selectedFields as $field) {
                //     $filters[$field] = [
                //         'operator' => $request->input($field . '_operator'),
                //         'value' => $request->input($field . '_value'),
                //         'from' => $request->input($field . '_from'),
                //         'to' => $request->input($field . '_to'),
                //     ];
                // }
                // $filteredData = $this->fetchFilteredDataForCustomExport(new Request(['filters' => $filters]));
                // \Log::info('Export Data:', $filteredData->toArray());
                // $export = new LoansExport($exportType, $selectedFields, $filters, $filteredData);
                // return Excel::download($export, 'loans_custom_export.xlsx');
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back();
        }
    }
    public function exportFetchedFilteredDataForQuickExport(array $filters)
    {
        $query = LoanApplication::query()->with('user:id,account_number');

        // \Log::info('Formatted Filters: ', $filters);

        foreach ($filters as $field => $options) {
            $value = $options['value'] ?? null;
            $operator = $options['operator'] ?? '=';
        
            if ($field === 'loan_type' && $value !== null) {
                $query->where($field, $operator ?: '=', $value);
            } elseif ($field === 'remarks' && $value !== null) {
                $query->where($field, $operator ?: '=', $value);
            } elseif ($field === 'application_status' && $value !== null) {
                $query->where($field, $operator ?: '=', $value);
            } elseif ($field === 'account_number' && $value !== null) {
                $query->whereHas('user', function ($subQuery) use ($value) {
                    $subQuery->where('account_number', '=', $value);
                });
            } else if ($value !== null) {
                $query->where($field, $operator, $value);
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

        // \Log::info('All Datasd:', $filteredData->toArray());

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
    $query = LoanApplication::query()->with('user');

    // \Log::info('Filters applied:', $filters);

    foreach ($filters as $field => $options) {
        $filterType = $options['fieldOption'] ?? null;
        $operator = $options['operator'] ?? null;
        $value = $options['value'] ?? null;
        $from = $options['from'] ?? null;
        $to = $options['to'] ?? null;

        if ($filterType === 'no_filter') {
            continue; // Skip filtering if "No Filters" is selected
        }

        if ($field === 'account_number') {
            $query->whereHas('user', function ($subQuery) use ($operator, $value) {
                $operator = $operator ?: '='; // Ensure there is a default operator
                $subQuery->where('account_number', $operator, $value);
            });
        } elseif ($filterType === 'range_based') {
            if (strpos($field, '_date') !== false) {
                // Handle date ranges
                $query->whereBetween($field, [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()]);
            } else {
                // Handle numeric ranges
                $query->whereBetween($field, [$from, $to]);
            }
        } elseif ($filterType === 'operator_based' && $operator && $value !== null) {
            $query->where($field, $operator, $value);
        } elseif ($value !== null && $operator === null && $filterType !== 'range_based') {
            $query->where($field, '=', $value);
        }
    }

    $filteredData = $query->get()->makeHidden(['applicant_sign', 'applicant_receipt'])
        ->map(function ($loanApplication, $index) {
            $loanApplicationArray = $loanApplication->toArray();
            $loanApplicationArray['id'] = $index + 1;
            $position = array_search('loan_reference', array_keys($loanApplicationArray)) + 1;
            $loanApplicationArray = array_slice($loanApplicationArray, 0, $position, true) +
                                    ['account_number' => $loanApplication->user->account_number] +
                                    array_slice($loanApplicationArray, $position, null, true);
            return $loanApplicationArray;
        });

    // \Log::info('Filtered data:', $filteredData->toArray());
    return $filteredData;
}

    public function fetchFilteredDataForCustomExport(Request $request)
    {
        $filters = $request->input('filters', []);
        $query = LoanApplication::query()->with('user');

        // \Log::info('Received filters at method start:', $filters);

        foreach ($filters as $field => $options) {
            $operator = $options['operator'] ?? null;
            $value = $options['value'] ?? null;
            $from = $options['from'] ?? null;
            $to = $options['to'] ?? null;

            if (!empty($value)) {
                if ($field === 'account_number') {
                    $query->whereHas('user', function ($subQuery) use ($operator, $value) {
                        $subQuery->where('account_number', $operator ?: '=', $value);
                    });
                } elseif (!empty($from) && !empty($to)) {
                    $query->whereBetween($field, [$from, $to]);
                } elseif (!empty($operator)) {
                    $query->where($field, $operator, $value);
                } else {
                    $query->where($field, '=', $value);
                }
            }
        }

        $filteredData = $query->get()->makeHidden(['applicant_sign', 'applicant_receipt'])
            ->map(function ($loanApplication, $index) {
                $loanApplicationArray = $loanApplication->toArray();
                $loanApplicationArray['id'] = $index + 1;
                $position = array_search('loan_reference', array_keys($loanApplicationArray)) + 1;
                $loanApplicationArray = array_slice($loanApplicationArray, 0, $position, true) +
                                        ['account_number' => $loanApplication->user->account_number] +
                                        array_slice($loanApplicationArray, $position, null, true);
                return $loanApplicationArray;
            });

        // \Log::info('Filtered data:', $filteredData->toArray());
        return $filteredData;
    }

    // public function exportData(Request $request, $selectedFields, $options)
    // {
    //     $query = LoanApplication::query()->with(['user']); // Ensure 'user' is correctly eager loaded

    //     \Log::info('Filters applied:', $options);

    //     foreach ($options as $field => $fieldOptions) {
    //         $operator = $fieldOptions['operator'][0] ?? null;
    //         $value = $fieldOptions['value'][0] ?? null;
    //         $from = $fieldOptions['from'][0] ?? null;
    //         $to = $fieldOptions['to'][0] ?? null;

    //         if ($field === 'account_number') {
    //             $query->whereHas('user', function ($subQuery) use ($operator, $value) {
    //                 if ($operator && $value !== null) {
    //                     $subQuery->where('account_number', $operator, $value);
    //                 } elseif ($value !== null) {
    //                     $subQuery->where('account_number', '=', $value);
    //                 }
    //             });
    //         } elseif ($from && $to) {
    //             $query->whereBetween($field, [$from, $to]);
    //         } elseif ($operator && $value !== null) {
    //             $query->where($field, $operator, $value);
    //         } elseif ($value !== null) {
    //             $query->where($field, '=', $value);
    //         }
    //     }

    //     $filteredData = $query->get()->makeHidden(['applicant_sign', 'applicant_receipt'])
    //         ->map(function ($loanApplication, $index) use ($selectedFields) {
    //             $loanApplicationArray = $loanApplication->toArray();
    //             $loanApplicationArray['id'] = $index + 1;
    //             // Include only selected fields
    //             return array_intersect_key($loanApplicationArray, array_flip($selectedFields));
    //         });

    //     \Log::info("Exported Data: ", $filteredData->toArray());
    //     return $filteredData;
    // }

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
    // private function applyFilters($query, $filters)
    // {
    //     foreach ($filters as $field => $options) {
    //         $filterType = $options['filter_type'] ?? null;
    //         $operator = $options['operator'] ?? null;
    //         $value = $options['value'] ?? null;
    //         $from = $options['from'] ?? null;
    //         $to = $options['to'] ?? null;

    //         if ($filterType == 'range_based' && $from && $to) {
    //             $query->whereBetween($field, [$from, $to]);
    //         } elseif ($filterType == 'operator_based' && $operator && $value !== null) {
    //             switch ($operator) {
    //                 case '==':
    //                     $query->where($field, $value);
    //                     break;
    //                 case '<=':
    //                     $query->where($field, '<=', $value);
    //                     break;
    //                 case '>=':
    //                     $query->where($field, '>=', $value);
    //                     break;
    //             }
    //         } elseif ($value !== null && $operator === null) {
    //             // This handles simple text input filters without specific operators
    //             // Adjust the logic as needed, e.g., using 'like' for partial matches
    //             $query->where($field, 'like', '%' . $value . '%');
    //         }
    //     }
    // }
}