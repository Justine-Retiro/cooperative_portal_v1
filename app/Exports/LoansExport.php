<?php
namespace App\Exports;

use App\Models\LoanApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Schema;

class LoansExport implements FromCollection, WithHeadings
{
    protected $exportType;
    protected $selectedFields;
    protected $options;
    protected $filteredData;

    public function __construct($exportType = 'quick', $selectedFields = [], $options = [], $filteredData = null)
    {
        $this->exportType = $exportType;
        $this->selectedFields = $selectedFields;
        $this->options = $options;
        $this->filteredData = $filteredData;
    }

    public function collection()
    {
        if ($this->exportType == 'quick') {
            if (!empty($this->filteredData)) {
                // Quick custom export: use the filtered data
                return $this->filteredData;
            } else {
                // Quick default export: select all fields
                return LoanApplication::get()->makeHidden(['id','applicant_sign', 'note', 'applicant_receipt', 'created_at', 'deleted_at', 'account_number_id', 'client_id', 'take_action_by_id']);
            }
        } else {
            // Custom Export: use selected fields
            if (empty($this->selectedFields)) {
                // Handle the case where no fields are selected, e.g., select a default set or throw an error
                throw new \Exception("No fields selected for export.");
            }

            // Validate field names
            $validFields = Schema::getColumnListing('loan_applications');
            foreach ($this->selectedFields as $field) {
                if (!in_array($field, $validFields)) {
                    throw new \Exception("Invalid field name: {$field}");
                }
            }

            $query = LoanApplication::select($this->selectedFields);

            // Apply filters based on selected fields and options
            foreach ($this->selectedFields as $field) {
                $operator = $this->options[$field]['operator'] ?? null;
                $value = $this->options[$field]['value'] ?? null;
                $from = $this->options[$field]['from'] ?? null;
                $to = $this->options[$field]['to'] ?? null;

                // Handle numeric fields with range
                if (in_array($field, ['age', 'monthly_pay', 'finance_charge', 'balance', 'financed_amount']) && $from && $to) {
                    $query->whereBetween($field, [$from, $to]);
                }
                // Handle numeric fields with operators
                elseif (in_array($field, ['age', 'monthly_pay', 'finance_charge', 'balance', 'financed_amount']) && $operator && $value !== null) {
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
                }
                // Handle date fields with a range
                elseif (in_array($field, ['birth_date', 'date_employed', 'application_date', 'due_date', 'created_at']) && $from && $to) {
                    $query->whereBetween($field, [$from, $to]);
                }
                // Handle application status
                elseif ($field == 'application_status' && $value) {
                    $query->where($field, $value);
                }
                // Handle string fields
                elseif (in_array($field, ['loan_reference', 'customer_name', 'contact_num', 'college', 'taxid_num', 'loan_type', 'work_position', 'retirement_year', 'time_pay', 'note', 'remarks']) && $value) {
                    $query->where($field, 'like', '%' . $value . '%');
                }
            }

            return $query->get()->makeHidden(['applicant_sign', 'applicant_receipt']);
        }
    }

    public function headings(): array
    {
        if ($this->exportType == 'quick') {
            return [
                '#', 'Loan Reference', 'Account Number', 'Customer Name', 'Age', 'Birth Date', 'Date employed',
                'Contact Number', 'College', 'Tax Id Number', 'Loan Type', 'Work Position',
                'Retirement Year', 'Application Date', 'Time to pay', 'Application Status',
                'Financed Amount', 'Monthly Installment', 'Finance Charge', 'Balance', 'Due Date', 'Remarks'
            ];
        } else {
            // Retrieve field positions from the session
            $fieldPositions = session('field_positions', []);

            // Reorder selected fields based on positions
            $selectedFields = [];
            foreach ($fieldPositions as $fieldName => $position) {
                if (in_array($fieldName, $this->selectedFields)) {
                    $selectedFields[$position] = $fieldName;
                }
            }
            ksort($selectedFields);

            // Generate headings based on selected fields
            return array_map(function($field) {
                switch ($field) {
                    case 'id':
                        return '#';
                    case 'loan_reference':
                        return 'Loan Reference';
                    case 'customer_name':
                        return 'Customer Name';
                    case 'age':
                        return 'Age';
                    case 'birth_date':
                        return 'Birth Date';
                    case 'date_employed':
                        return 'Date Employed';
                    case 'contact_num':
                        return 'Contact Number';
                    case 'college':
                        return 'College';
                    case 'taxid_num':
                        return 'Tax ID Number';
                    case 'loan_type':
                        return 'Loan Type';
                    case 'work_position':
                        return 'Work Position';
                    case 'retirement_year':
                        return 'Retirement Year';
                    case 'application_date':
                        return 'Application Date';
                    case 'time_pay':
                        return 'Time to Pay';
                    case 'application_status':
                        return 'Application Status';
                    case 'financed_amount':
                        return 'Financed Amount';
                    case 'monthly_pay':
                        return 'Monthly Pay';
                    case 'finance_charge':
                        return 'Finance Charge';
                    case 'balance':
                        return 'Balance';
                    case 'note':
                        return 'Note';
                    case 'due_date':
                        return 'Due Date';
                    case 'remarks':
                        return 'Remarks';
                    case 'created_at':
                        return 'Application Date';
                    default:
                        return ucwords(str_replace('_', ' ', $field));
                }
            }, $this->selectedFields);
        }
    }
}