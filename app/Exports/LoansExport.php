<?php
namespace App\Exports;

use App\Models\LoanApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\Schema;

class LoansExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting{
    protected $exportType;
    protected $selectedFields;
    protected $options;
    protected $filteredData;
    protected $quickExportOption;

    public function __construct($exportType = 'quick', $selectedFields = [], $options = [], $filteredData = null, $quickExportOption = null)
{
    $this->exportType = $exportType;
    $this->selectedFields = $selectedFields;
    $this->options = $options;
    $this->filteredData = $filteredData;
    $this->quickExportOption = $quickExportOption;
}

    public function map($loanApplication): array
    {
        
        if ($this->exportType === 'custom') {
            \Illuminate\Support\Facades\Log::info('Mapping loan application:', ['data' => $loanApplication->toArray()]);
            return collect($this->selectedFields)->map(function ($field) use ($loanApplication) {
                if ($field === 'account_number') {
                    \Illuminate\Support\Facades\Log::info('Account Number:', ['account_number' => optional($loanApplication->user)->account_number]);
                    return optional($loanApplication->user)->account_number;
                }
                return $loanApplication->$field;
            })->toArray();
        }  elseif ($this->exportType === 'quick') {
            $accountNumber = 'Account Number'; // Default placeholder
            if ($this->quickExportOption === 'custom') {
                $accountNumber = $loanApplication['account_number'] ?? 'Account Number';
            } elseif ($this->quickExportOption === 'default') {
                $accountNumber =  optional($loanApplication->user)->account_number ?? 'Account Number';
               
            }
                return [
                    $loanApplication['id'],
                    $loanApplication['loan_reference'],
                    'Account Number' => $accountNumber,
                    $loanApplication['customer_name'],
                    $loanApplication['age'],
                    $loanApplication['birth_date'],
                    $loanApplication['date_employed'],
                    $loanApplication['contact_num'],
                    $loanApplication['college'],
                    $loanApplication['taxid_num'],
                    $loanApplication['loan_type'],
                    $loanApplication['work_position'],
                    $loanApplication['retirement_year'],
                    $loanApplication['application_date'],
                    $loanApplication['time_pay'],
                    $loanApplication['application_status'],
                    $loanApplication['financed_amount'],
                    $loanApplication['monthly_pay'],
                    $loanApplication['finance_charge'],
                    $loanApplication['balance'],
                    $loanApplication['due_date'],
                    $loanApplication['remarks']
                ];            
        } else {
            return [];
        }
    }

    public function columnFormats(): array
    {
        return collect($this->selectedFields)->mapWithKeys(function ($field, $index) {
            if ($field === 'account_number') {
                return [$this->columnLetter($index) => NumberFormat::FORMAT_TEXT];
            } elseif (in_array($field, ['finance_charge', 'balance', 'monthly_pay', 'financed_amount'])) {
                return [$this->columnLetter($index) => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1];
            }
            return [$this->columnLetter($index) => NumberFormat::FORMAT_GENERAL];
        })->toArray();
    }

    public function collection()
    {
        if ($this->exportType == 'quick') {
            if (!empty($this->filteredData)) {
                // \Log::info('Filtered Data:', ['data' => $this->filteredData]);
                return $this->filteredData;
            } else {
                // Quick default export: select all fields
                $allData = LoanApplication::get()->makeHidden(['id','applicant_sign', 'note', 'applicant_receipt', 'created_at', 'deleted_at', 'account_number_id', 'client_id', 'take_action_by_id']);
                // \Log::info('All Data:', $allData->toArray()); // Make sure to remove or secure logs in production
                return $allData;
                // return LoanApplication::get()->makeHidden(['id','applicant_sign', 'note', 'applicant_receipt', 'created_at', 'deleted_at', 'account_number_id', 'client_id', 'take_action_by_id']);
            }
        } else {
            if (empty($this->selectedFields)) {
                throw new \Exception("No fields selected for export.");
            }

            return $this->query()->get()->makeHidden(['id','applicant_sign', 'note', 'applicant_receipt', 'created_at', 'deleted_at', 'client_id', 'take_action_by_id']);
        }
    }

    public function query()
    {
        $query = LoanApplication::query();
        $query->join('users', 'loan_applications.account_number_id', '=', 'users.id');

        // Select fields from loan_applications and the account_number from users
        $fields = ['loan_applications.*', 'users.account_number as account_number'];
        $query->select($fields);

        // Apply filters based on selected fields and options
        foreach ($this->selectedFields as $field) {
            $fieldOptions = $this->options[$field] ?? [];
            $operator = $fieldOptions['operator'][0] ?? null;
            $value = $fieldOptions['value'][0] ?? null;
            $from = $fieldOptions['from'][0] ?? null;
            $to = $fieldOptions['to'][0] ?? null;
        
            if ($field === 'age') {
                if ($from && $to) {
                    $query->whereBetween('loan_applications.age', [$from, $to]);
                }
            }

            // Adjust field name if it's 'account_number'
            if ($field === 'account_number') {
                $field = 'users.account_number';
            } else {
                $field = 'loan_applications.' . $field;
            }


            // Apply operator-based filters
            if (in_array($field, ['loan_applications.age', 'loan_applications.financed_amount', 'loan_applications.monthly_pay', 'loan_applications.finance_charge', 'loan_applications.balance']) && $operator && $value !== null) {
                $query->where($field, $operator, $value);
            }

            // Apply range-based filters
            if (in_array($field, ['loan_applications.birth_date', 'loan_applications.date_employed', 'loan_applications.application_date', 'loan_applications.due_date', 'loan_applications.created_at']) && $from && $to) {
                $query->whereBetween($field, [$from, $to]);
            }

            // Apply like filters for textual data
            if (in_array($field, ['loan_applications.loan_reference', 'loan_applications.customer_name', 'loan_applications.contact_num', 'loan_applications.college', 'loan_applications.taxid_num', 'loan_applications.loan_type', 'loan_applications.work_position', 'loan_applications.retirement_year', 'loan_applications.time_pay', 'loan_applications.note', 'loan_applications.remarks', 'users.account_number']) && $value) {
                $query->where($field, 'like', '%' . $value . '%');
            }
        }

        return $query;
    }

    public function headings(): array
    {
        if ($this->exportType == 'quick') {
            return [
                'id' => '#',
                'loan_reference' => 'Loan Reference',
                'account_number' => 'Account Number',
                'customer_name' => 'Customer Name',
                'age' => 'Age',
                'birth_date' => 'Birth Date',
                'date_employed' => 'Date Employed',
                'contact_num' => 'Contact Number',
                'college' => 'College',
                'taxid_num' => 'Tax ID Number',
                'loan_type' => 'Loan Type',
                'work_position' => 'Work Position',
                'retirement_year' => 'Retirement Year',
                'application_date' => 'Application Date',
                'time_pay' => 'Time to Pay',
                'application_status' => 'Application Status',
                'financed_amount' => 'Financed Amount',
                'monthly_pay' => 'Monthly Pay',
                'finance_charge' => 'Finance Charge',
                'balance' => 'Balance',
                'due_date' => 'Due Date',
                'remarks' => 'Remarks',
            ];
        } else {
            $fieldToHeaderMap = [
                'id' => '#',
                'loan_reference' => 'Loan Reference',
                'customer_name' => 'Customer Name',
                'age' => 'Age',
                'birth_date' => 'Birth Date',
                'date_employed' => 'Date Employed',
                'contact_num' => 'Contact Number',
                'college' => 'College',
                'taxid_num' => 'Tax ID Number',
                'loan_type' => 'Loan Type',
                'work_position' => 'Work Position',
                'retirement_year' => 'Retirement Year',
                'application_date' => 'Application Date',
                'time_pay' => 'Time to Pay',
                'application_status' => 'Application Status',
                'financed_amount' => 'Financed Amount',
                'monthly_pay' => 'Monthly Pay',
                'finance_charge' => 'Finance Charge',
                'balance' => 'Balance',
                'note' => 'Note',
                'due_date' => 'Due Date',
                'remarks' => 'Remarks',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
                'client_id' => 'Client ID',
                'take_action_by_id' => 'Action Taken By ID',
                'account_number' => 'Account Number',
            ];

            // Generate headers based on selected fields
            return collect($this->selectedFields)->map(function ($field) use ($fieldToHeaderMap) {
                return $fieldToHeaderMap[$field] ?? ucwords(str_replace('_', ' ', $field));
            })->toArray();
        }
    }

    private function columnLetter($index)
    {
        return chr(65 + $index);
    }
}