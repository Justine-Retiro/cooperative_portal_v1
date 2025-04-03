@extends('layouts.app')
@section('title', 'Export')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/application.css') }}">
@endsection
@section('content')
<div id="page-content-wrapper">
    <div class="spinner-body position-absolute top-50 start-50 translate-middle z-3">
        <div class="spinner"></div>
    </div>
    <div class="container-fluid xyz pe-0">
        <div class="row">
            <div class="col-lg-12">
                <h1>Export Applications</h1> 
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.loan.home') }}" class="text-decoration-none">Members Loan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Export Application</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="mt-0 p-2 px-3">
                        <h4 class="m-0">Export Method</h4>
                        <hr>
                        <div class="mx-2 px-2">
                            <div class="export-options">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exportOption" id="quickExport" value="quick" checked>
                                    <label class="form-check-label py-0" for="quickExport">Quick Export</label>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Export all records"><i class="bi bi-info-circle"></i></span>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exportOption" id="customExport" value="custom">
                                    <label class="form-check-label py-0" for="customExport">Custom Export</label>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Export specific records"><i class="bi bi-info-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3" id="exportQuick">
                    <div class="mt-0 p-2 px-3">
                        <h4 class="m-0">Export Format</h4>
                        <hr>
                        <div class="mx-2 px-2">
                            <div id="quickExportSection" class="export-section">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="quickExportOption" id="defaultQuickExport" value="default" checked>
                                    <label class="form-check-label py-0" for="defaultQuickExport">Default</label>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Instant export."><i class="bi bi-info-circle"></i></span>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="quickExportOption" id="customQuickExport" value="custom">
                                    <label class="form-check-label py-0" for="customQuickExport">Custom</label>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="Customize export"><i class="bi bi-info-circle"></i></span>
                                </div>
                            </div>
                            <div id="customQuickExportOptions" class="mt-3" style="display: none;">
                                <p>Select fields to refine your export data.</p>
                                <form action="{{ route('admin.export') }}" method="POST" id="quickExportForm">
                                    @csrf
                                    <input type="hidden" name="export_type" value="quick">
                                    <input type="hidden" name="quickExportOption" value="custom">
                                    <div class="form-group">
                                        <label for="quickFieldSelection">Add Fields:</label>
                                        <select class="form-control" id="quickFieldSelection">
                                            <option value="">Select a field</option>
                                            @php
                                                $fields = [
                                                    'account_number', 'customer_name', 'age', 'birth_date', 'date_employed',
                                                    'contact_num', 'college', 'taxid_num', 'loan_type', 'work_position',
                                                    'retirement_year', 'application_date', 'time_pay', 'application_status',
                                                    'financed_amount', 'monthly_pay', 'finance_charge', 'balance', 'due_date', 'remarks'
                                                ];
                                            @endphp
                                            @foreach($fields as $field)
                                                <option value="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</option>
                                            @endforeach
                                        </select>
                                        <div class="mt-2">
                                            <button type="button" id="addQuickFieldBtn" class="btn btn-primary">Add Field</button>
                                            <button type="button" id="previewQuickExportBtn" class="btn btn-secondary">Preview Quick Export</button>
                                        </div>
                                    </div>
                                    <table class="table" id="quickFieldsTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;"></th>
                                                <th>Field Name</th>
                                                <th>Option</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Rows will be added here dynamically -->
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-success d-none" id="btnQuickExportForm">Export</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3 d-none" id="exportCustom">
                    <div class="mt-0 p-2 px-3">
                        <h4 class="m-0">Export Options</h4>
                        <hr>
                        <div class="mx-2 px-3">
                            <div id="customExportSection" class="export-section" style="display: none;">
                                <p>Choose the data you want to export.</p>
                                <form action="{{ route('admin.export') }}" method="POST" id="exportForm">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    @method('POST')
                                    <div class="form-group">
                                        <label for="fieldSelection">Add Fields:</label>
                                        <select class="form-control" id="fieldSelection">
                                            <option value="">Select a field</option>
                                            @php
                                                $fields = [
                                                    'account_number', 'loan_reference', 'customer_name', 'age', 'birth_date', 'date_employed',
                                                    'contact_num', 'college', 'taxid_num', 'loan_type', 'work_position',
                                                    'retirement_year', 'application_date', 'time_pay', 'application_status',
                                                    'financed_amount', 'monthly_pay', 'finance_charge', 'balance', 'due_date', 'remarks'
                                                ];
                                            @endphp
                                            @foreach($fields as $field)
                                                <option value="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</option>
                                            @endforeach
                                        </select>
                                        <div class="mt-2">
                                            <button type="button" id="addFieldBtn" class="btn btn-primary">Add Field</button>
                                            <button type="button" id="dynamicExcelPreviewBtn" class="btn btn-secondary">Preview Excel Records</button>
                                        </div>
                                    </div>
                                    <table class="table" id="fieldsTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px;"></th>
                                                <th class="fw-medium">Field Name</th>
                                                <th class="fw-medium">Option</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Rows will be added here dynamically -->
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <input type="hidden" name="export_type" value="custom">
                    <button type="submit" id="btnCustomExport" class="btn btn-success d-none">Export</button>
                </form>
                </div>
                <div id="selectedFieldsContainer"></div>
                <div class="mt-3 defaultQuickExportForm">
                    <form id="defaultQuickExportForm" method="POST">
                        @csrf
                        <input type="hidden" name="export_type" value="quick">
                        <input type="hidden" name="quickExportOption" value="default">
                        <button type="submit" class="btn-success btn" id="btnQuickExport">Export</button>
                    </form>
                    <button type="button" class="btn-success btn visibleExportBtn " style="display:none;">Export</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Excel Preview Modal -->
<div class="modal fade" id="dynamicExcelPreviewModal" tabindex="-1" aria-labelledby="dynamicExcelPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dynamicExcelPreviewModalLabel">Excel Export Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-wrapper">
                <!-- Table will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@if(session('error'))
    <script>
        $(document).ready(function() {
            toastr.error('{{ session('error') }}');
        });
    </script>
@endif


<script>
$(document).ready(function() {
    $('#dynamicExcelPreviewBtn').click(function(event) {
        event.preventDefault();
        var filters = {};
        var selectedFieldNames = [];
        var isValid = true; // Flag to check if all conditions are met

        $('#fieldsTable tbody tr').each(function() {
            var fieldName = $(this).find('td[data-field-name]').data('field-name');
            var fieldOption = $(this).find('input[name="' + fieldName + '_filter_type"]:checked').val();
            var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
            var value = '';

            // Special handling for 'account_number' field
            if (fieldName === 'account_number' && fieldOption === 'custom_based') {
                value = $(this).find('.customRangeInputs input[name="' + fieldName + '_value"]').val();
            } else {
                value = $(this).find('input[name="' + fieldName + '_value"]').val() || $(this).find('select[name="' + fieldName + '_value"]').val();
            }

            // Handle numeric and date fields with range or operator-based options
            var from = '';
            var to = '';
            if (fieldOption === 'range_based' || fieldOption === 'operator_based') {
                from = $(this).find('input[name="' + fieldName + '_from"]').val();
                to = $(this).find('input[name="' + fieldName + '_to"]').val();
            }

            filters[fieldName] = { fieldOption, operator, value, from, to };
            selectedFieldNames.push(fieldName);

            // Apply this validation only on custom export
            if ($('input[name="exportOption"]').val() === 'custom') {
                if (fieldOption !== 'no_filter' && (!from && !to)) {
                    isValid = false;
                    toastr.error('Please provide a value for all selected filters.');
                    return false; // Break the loop
                }
            }
        });

        if (!isValid) {
            return; // Stop the function if validation fails
        }

        $.ajax({
            url: '/admin/fetch-filtered-data',
            type: 'POST',
            data: { filters: filters },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                var tableHtml = '<table class="table table-bordered"><thead><tr>';

                selectedFieldNames.forEach(function(fieldName) {
                    tableHtml += `<th>${fieldName.replace(/_/g, ' ').toUpperCase()}</th>`;
                });

                tableHtml += '</tr></thead><tbody>';

                response.forEach(function(item) {
                    tableHtml += '<tr>';
                    selectedFieldNames.forEach(function(fieldName) {
                        // Check if the field value is 'N/A' and display it accordingly
                        var displayValue = item[fieldName] === 'N/A' ? 'N/A' : (item[fieldName] || '');
                        tableHtml += `<td>${displayValue}</td>`;
                    });
                    tableHtml += '</tr>';
                });

                tableHtml += '</tbody></table>';

                $('#dynamicExcelPreviewModal .modal-body').html(tableHtml);
                $('#dynamicExcelPreviewModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: ", error);
            }
        });
    });
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('#btnCustomExport, .visibleExportBtn').click(function(event) {
        event.preventDefault();  // Prevent the default form submission

        if ($(this).hasClass('visibleExportBtn')) {
            // Programmatically click the hidden submit button inside the form
            $('#btnQuickExportForm').click();
        } else {
            // let hasValidFilters = false;

            // // Check each row to see if there's at least one with a filter other than 'no_filter' and ensure it has a value
            // $('#fieldsTable tbody tr, #quickFieldsTable tbody tr').each(function() {
            //     const filterType = $(this).find('input[name$="_filter_type"]:checked').val();
            //     const filterValue = $(this).find('input[name$="_value"]').val();
            //     if (filterType && filterType !== 'no_filter' && filterValue) {
            //         hasValidFilters = true;
            //     }
            // });

            // if (!hasValidFilters) {
            //     alert("Please select at least one filter other than 'No Filter' and provide a value before exporting.");
            //     return;
            // }

            // If validation passes, proceed with form submission
            $(this).closest('form').submit();
        }
    });

   
    // ____________________Buttons_____________________//
    $('#quickExport').click(function() {
        $('#exportQuick').show();
        $('#quickExportSection').show();
        $('#btnQuickExport').show();
        $('#btnCustomExport').hide().addClass('d-none');
        $('#customExportSection').hide();
        $('#exportCustom').hide().addClass('d-none');
    });

    $('#customExport').click(function() {
        $('#exportQuick').hide();
        $('#quickExportSection').hide();
        $('#btnQuickExport').hide();
        $('#btnCustomExport').removeClass('d-none').addClass('d-block');
        $('#customExportSection').show();
        $('#exportCustom').removeClass('d-none').addClass('d-block');
    });


    $('input[name="exportOption"]').change(function() {
        var exportVal = $(this).val();
        console.log("Export option changed to:", exportVal);
        if (exportVal === 'quick') {
            console.log("Showing quick export forms");
            $('.defaultQuickExportForm, #defaultQuickExportForm, #btnQuickExportForm').show();
            $('#customQuickExportOptions').hide(); // Ensure custom options are hidden when switching back to quick
            $('.visibleExportBtn').hide(); // Hide visible buttons that should not be shown in quick export
        } else {
            console.log("Hiding quick export forms");
            $('.defaultQuickExportForm, #defaultQuickExportForm, #btnQuickExportForm').hide();
        }
    });   
    
    $('input[name="quickExportOption"]').change(function() {
        if ($(this).val() === 'custom') {
            $('#customQuickExportOptions').show();
            $('#defaultQuickExportForm').hide();
            $('.visibleExportBtn').show();
        } else {
            $('#customQuickExportOptions').hide();
            $('#defaultQuickExportForm').show();
            $('.visibleExportBtn').hide();
        }
    });
    // _________________________________________________________//

    // ________________Input Fields_____________________________//
    const fieldsWithCustomRange = [
        'account_number', 'time_pay', 'application_status', 
        'remarks', 'loan_type', 'work_position', 
        'college',
    ];
    const numericalFields = ['monthly_pay', 'finance_charge', 'balance', 'financed_amount', 'age', 'retirement_year'];
    const dateFields = ['date_employed', 'due_date', 'application_date', 'created_at', 'birth_date'];

    // ___________________ Custom Export ____________________________//
    // Add field for custom export
    $('#addFieldBtn').click(function() {
        var selectedField = $('#fieldSelection').val();
        if (selectedField === "") {
            alert("Please select a valid field.");
            return;
        }
        var selectedFieldName = $('#fieldSelection option:selected').text();
        var isNumericalField = numericalFields.includes(selectedField);
        var isDateField = dateFields.includes(selectedField);
        var allowsCustomRange = fieldsWithCustomRange.includes(selectedField);
        var inputType = 'text';
        if (isNumericalField) inputType = 'number';
        else if (isDateField) inputType = 'date';

        // Generate filter type selection HTML based on field properties
        var filterTypeSelectionHtml = `
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="${selectedField}_filter_type" id="${selectedField}_no_filter" value="no_filter" checked>
                    <label class="form-check-label" for="${selectedField}_no_filter">No Filters</label>
                </div>
                ${isNumericalField || isDateField ? `
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="${selectedField}_filter_type" id="${selectedField}_range_based" value="range_based">
                    <label class="form-check-label" for="${selectedField}_range_based">Range Based</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="${selectedField}_filter_type" id="${selectedField}_operator_based" value="operator_based">
                    <label class="form-check-label" for="${selectedField}_operator_based">Operator Based</label>
                </div>` : ''}
                ${allowsCustomRange ? `
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="${selectedField}_filter_type" id="${selectedField}_custom_based" value="custom_based">
                    <label class="form-check-label" for="${selectedField}_custom_based">Custom</label>
                </div>` : ''}
            </div>
        `;

        var customInputsHtml;
        switch (selectedField) {
            case 'remarks':
                customInputsHtml = `
                    <td>
                        <select class="form-control" name="${selectedField}_value">
                            <option value="">Select an option</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                    </td>
                `;
                break;
            case 'loan_type':
                customInputsHtml = `
                    <td>
                        <select class="form-control" name="${selectedField}_value">
                            <option value="">Select an option</option>
                            <option value="regular">Regular</option>
                            <option value="regular w/renewal">Regular w/Renewal</option>
                            <option value="providential">Providential</option>
                            <option value="providential w/renewal">Providential w/Renewal</option>
                        </select>
                    </td>
                `;
                break;
            case 'application_status':
                customInputsHtml = `
                    <td>
                        <select class="form-control" name="${selectedField}_value">
                            <option value="">Select an option</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </td>
                `;
                break;
            default:
                customInputsHtml = allowsCustomRange || isNumericalField || isDateField ? `
                    <td class="customInputs">
                        ${filterTypeSelectionHtml}
                        <div class="customFilter invisible">
                            <div class="operatorInputs" style="display:none;">
                                <label>Operator:</label>
                                <div class="d-flex gap-2">
                                    <select class="form-control" name="${selectedField}_operator">
                                        <option value="">Select Operator</option>
                                        <option value="=">Equal to</option>
                                        <option value="<=">Less than or equal to</option>
                                        <option value=">=">Greater than or equal to</option>
                                    </select>
                                    <input type="${inputType}" class="form-control" name="${selectedField}_value" min="0" placeholder="Value" required>
                                </div>
                            </div>
                            <div class="rangeInputs" style="display:none;">
                                <div class="d-flex gap-2">
                                    <div>
                                        <label for="${selectedField}_from">From:</label>
                                        <input type="${inputType}" class="form-control" id="${selectedField}_from" name="${selectedField}_from" required>
                                    </div>
                                    <div>
                                        <label for="${selectedField}_to">To:</label>
                                        <input type="${inputType}" class="form-control" id="${selectedField}_to" name="${selectedField}_to" required>
                                    </div>
                                </div>
                            </div>
                            ${allowsCustomRange ? `
                                <div class="customRangeInputs">
                                    <input type="text" class="form-control" name="${selectedField}_value" placeholder="Enter custom value" required>
                                </div>
                            ` : ''}
                        </div>
                    </td>
                ` : '<td></td>';
        }

        var newRowHtml = `
            <tr>
                <td class="drag-handle"><i class="bi bi-grip-vertical"></i></td>
                <td data-field-name="${selectedField}">${selectedFieldName}</td>
                ${customInputsHtml}
                <td><button type="button" class="btn btn-danger btn-sm deleteFieldBtn" data-id="${selectedField}"><i class="bi bi-trash"></i></button></td>
            </tr>
        `;

        var newRow = $(newRowHtml);
        $('#fieldsTable tbody').append(newRow);

        newRow.find(`input[name="${selectedField}_filter_type"]`).change(function() {
            const selectedFilterType = $(this).val();
            const operatorInputs = newRow.find('.operatorInputs');
            const rangeInputs = newRow.find('.rangeInputs');
            const customFilter = newRow.find('.customFilter');
            const customRangeInputs = newRow.find('.customRangeInputs');

            if (selectedFilterType === 'no_filter') {
                customFilter.addClass('invisible');
                customRangeInputs.hide();
            } else if (selectedFilterType === 'range_based') {
                customFilter.removeClass('invisible').addClass('visible');
                operatorInputs.hide();
                rangeInputs.show();
                customRangeInputs.hide();
            } else if (selectedFilterType === 'operator_based') {
                customFilter.removeClass('invisible').addClass('visible');
                operatorInputs.show();
                rangeInputs.hide();
                customRangeInputs.hide();
            } else if (selectedFilterType === 'custom_based') {
                customFilter.removeClass('invisible').addClass('visible');
                operatorInputs.hide();
                rangeInputs.hide();
                customRangeInputs.show();
            }
        });

        $('#fieldSelection').val(''); // Reset the dropdown
    });
    

    function checkFieldSelection() {
        var hasFields = $('#quickFieldsTable tbody tr').length > 0;
        $('#btnQuickExport').prop('disabled', !hasFields); // Enable button only if fields are selected
    }


    


    // ________________Quick Custom Export___________________________ //
    // Add field for quick custom export
    $('#addQuickFieldBtn').click(function() {
        var selectedField = $('#quickFieldSelection').val();
        if (selectedField === "") {
            alert("Please select a valid field.");
            return;
        }
        var selectedFieldName = $('#quickFieldSelection option:selected').text();
        var isNumericalField = numericalFields.includes(selectedField);
        var isDateField = dateFields.includes(selectedField);
        var allowsCustomRange = fieldsWithCustomRange.includes(selectedField);
        var inputType = 'text';
        if (isNumericalField) inputType = 'number';
        else if (isDateField) inputType = 'date';

        var filterTypeSelectionHtml = isNumericalField || isDateField ? `
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="${selectedField}_filter_type" id="${selectedField}_no_filter" value="no_filter" checked>
                    <label class="form-check-label" for="${selectedField}_no_filter">No Filters</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="${selectedField}_filter_type" id="${selectedField}_range_based" value="range_based">
                    <label class="form-check-label" for="${selectedField}_range_based">Range Based</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="${selectedField}_filter_type" id="${selectedField}_operator_based" value="operator_based">
                    <label class="form-check-label" for="${selectedField}_operator_based">Operator Based</label>
                </div>
            </div>
        ` : '';

        var customInputsHtml;
        switch (selectedField) {
            case 'remarks':
                customInputsHtml = `
                    <td>
                        <select class="form-control" name="${selectedField}_value">
                            <option value="">Select an option</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                        </select>
                    </td>
                `;
                break;
            case 'loan_type':
                customInputsHtml = `
                    <td>
                        <select class="form-control" name="${selectedField}_value">
                            <option value="">Select an option</option>
                            <option value="regular">Regular</option>
                            <option value="regular w/renewal">Regular w/Renewal</option>
                            <option value="providential">Providential</option>
                            <option value="providential w/renewal">Providential w/Renewal</option>
                        </select>
                    </td>
                `;
                break;
            case 'application_status':
                customInputsHtml = `
                    <td>
                        <select class="form-control" name="${selectedField}_value">
                            <option value="">Select an option</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </td>
                `;
                break;
            case 'taxid_num':
            case 'account_number':
            case 'college':
            case 'customer_name':
            case 'work_position':
                customInputsHtml = `
                    <td>
                        <input type="text" class="form-control" name="${selectedField}_value" placeholder="Enter ${selectedFieldName}" required>
                    </td>
                `;
                break;
            default:
                customInputsHtml = allowsCustomRange || isNumericalField || isDateField ? `
                    <td class="customInputs">
                        ${filterTypeSelectionHtml}
                        <div class="customFilter invisible">
                            <div class="operatorInputs" style="display:none;">
                                <label>Operator:</label>
                                <div class="d-flex gap-2">
                                    <select class="form-control" name="${selectedField}_operator">
                                        <option value="">Select Operator</option>
                                        <option value="==">Equal to</option>
                                        <option value="<=">Less than or equal to</option>
                                        <option value=">=">Greater than or equal to</option>
                                    </select>
                                    <input type="${inputType}" class="form-control" name="${selectedField}_value" placeholder="Value">
                                </div>
                            </div>
                            <div class="rangeInputs" style="display:none;">
                                <div class="d-flex gap-2">
                                    <div>
                                        <label for="${selectedField}_from">From:</label>
                                        <input type="${inputType}" class="form-control" id="${selectedField}_from" name="${selectedField}_from">
                                    </div>
                                    <div>
                                        <label for="${selectedField}_to">To:</label>
                                        <input type="${inputType}" class="form-control" id="${selectedField}_to" name="${selectedField}_to">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                ` : '<td>N/A</td>';
        }

        var newRowHtml = `
            <tr>
                <td class="drag-handle"><i class="bi bi-grip-vertical"></i></td>
                <td data-field-name="${selectedField}">${selectedFieldName}</td>
                ${customInputsHtml}
                <td><button type="button" class="btn btn-danger btn-sm deleteFieldBtn"><i class="bi bi-trash"></i></button></td>
            </tr>
        `;

        var newRow = $(newRowHtml);
        $('#quickFieldsTable tbody').append(newRow);

        newRow.find(`input[name="${selectedField}_filter_type"]`).change(function() {
            const selectedFilterType = $(this).val();
            const operatorInputs = newRow.find('.operatorInputs');
            const rangeInputs = newRow.find('.rangeInputs');
            const customFilter = newRow.find('.customFilter');

            if (selectedFilterType === 'no_filter') {
                customFilter.addClass('invisible');
            } else if (selectedFilterType === 'range_based') {
                customFilter.removeClass('invisible').addClass('visible');
                operatorInputs.hide();
                rangeInputs.show();
            } else if (selectedFilterType === 'operator_based') {
                customFilter.removeClass('invisible').addClass('visible');
                operatorInputs.show();
                rangeInputs.hide();
            }
        });

        $('#quickFieldSelection').val(''); // Reset the dropdown
    });

    $("#fieldsTable tbody").sortable({
        items: "tr",
        handle: ".drag-handle",
        cursor: 'move',
        opacity: 0.6,
        helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        },
        update: function() {
            $.ajax({
                url: "{{ route('admin.update-row-position') }}",
                type: 'POST',
                data: {
                    order: $(this).sortable('toArray', {attribute: 'data-field-name'}).join(','),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('Row positions updated successfully.');
                },
                error: function() {
                    toastr.error('An error occurred while updating row positions.');
                }
            });
        }
    }).disableSelection();

    $("#quickFieldsTable tbody").sortable({
        items: "tr",
        handle: ".drag-handle",
        cursor: 'move',
        opacity: 0.6,
        helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        },
        update: function() {
            $.ajax({
                url: "{{ route('admin.update-row-position') }}",
                type: 'POST',
                data: {
                    order: $(this).sortable('toArray', {attribute: 'data-field-name'}).join(','),
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('Row positions updated successfully.');
                },
                error: function() {
                    toastr.error('An error occurred while updating row positions.');
                }
            });
        }
    }).disableSelection();

    $('#fieldsTable').on('click', '.deleteFieldBtn', function() {
        $(this).closest('tr').remove();
    });

    $('#quickFieldsTable').on('click', '.deleteFieldBtn', function() {
        var fieldName = $(this).closest('tr').find('td[data-field-name]').data('field-name');
        if (fieldName && quickExportFilters[fieldName]) {
            delete quickExportFilters[fieldName];  // Remove the filter from the object
        }
        $(this).closest('tr').remove();  // Remove the row from the table
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // _________________________Exporting____________________________ //
    $('#btnCustomExport').click(function(event) {
        event.preventDefault(); // Prevent the default form submission
        event.stopPropagation();
        var customExportOption = $('input[name="exportOption"]:checked').val();

        if (customExportOption === 'custom' && !$('#fieldsTable tbody tr').length) {
            toastr.error('No fields selected for custom export.');
            return;
        }

        var hasSelectedFields = $('#fieldsTable tbody tr').length > 0;

        if (!hasSelectedFields) {
            toastr.error('Selected fields are required for custom export.');
            return;
        }

        // Clear previous hidden inputs related to filters
        $('#exportForm input[type="hidden"]').remove();

        // Append necessary data for each selected field
        $('#fieldsTable tbody tr').each(function() {
            var fieldName = $(this).find('td[data-field-name]').data('field-name');
            var filterType = $(this).find('input[name="' + fieldName + '_filter_type"]:checked').val();

            // Append field name
            $('#exportForm').append($('<input>').attr({
                type: 'hidden',
                name: 'selected_fields[]',
                value: fieldName
            }));

            // Check if a filter option is selected (excluding 'no_filter')
            if (filterType !== 'no_filter') {
                var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
                var value = $(this).find('input[name="' + fieldName + '_value"]').val();
                var from = $(this).find('input[name="' + fieldName + '_from"]').val();
                var to = $(this).find('input[name="' + fieldName + '_to"]').val();

                // Append filter details
                $('#exportForm').append($('<input>').attr({
                    type: 'hidden',
                    name: fieldName + '_filter_type',
                    value: filterType
                }));

                if (operator) {
                    $('#exportForm').append($('<input>').attr({
                        type: 'hidden',
                        name: fieldName + '_operator',
                        value: operator
                    }));

                    $('#exportForm').append($('<input>').attr({
                        type: 'hidden',
                        name: fieldName + '_value',
                        value: value
                    }));
                }

                if (from && to) {
                    $('#exportForm').append($('<input>').attr({
                        type: 'hidden',
                        name: fieldName + '_from',
                        value: from
                    }));

                    $('#exportForm').append($('<input>').attr({
                        type: 'hidden',
                        name: fieldName + '_to',
                        value: to
                    }));
                }
            }
        });
        var formData = $('#exportForm').serialize();

        $.ajax({
            url: "{{ route('admin.export') }}",
            type: 'POST',
            data: formData,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'export.xlsx';
                link.click();
            },
            error: function(xhr, status, error) {
                toastr.error('Error during export: ' + error);
                console.error("Error: " + error);
                console.error("Status: " + status);
                console.error("Response: " + xhr.responseText);
            }
        });
    });

    $('#fieldsTable').on('change', 'input[type="radio"][name$="_filter_type"]', function() {
        var tr = $(this).closest('tr');
        var selectedFilterType = $(this).val();
        var operatorInputs = tr.find('.operatorInputs');
        var rangeInputs = tr.find('.rangeInputs');
        var customFilter = tr.find('.customFilter');

        // Reset inputs when no filter is selected
        if (selectedFilterType === 'no_filter') {
            customFilter.addClass('invisible');
            operatorInputs.hide();
            rangeInputs.hide();
            tr.find('input[type="text"], input[type="number"], select').val(''); // Clear values
        } else if (selectedFilterType === 'range_based') {
            customFilter.removeClass('invisible').addClass('visible');
            operatorInputs.hide();
            rangeInputs.show();
        } else if (selectedFilterType === 'operator_based') {
            customFilter.removeClass('invisible').addClass('visible');
            operatorInputs.show();
            rangeInputs.hide();
        }
    });

    // ____________________________End Export Custom______________________________ //

    var quickExportFilters = {};
    
    $('#previewQuickExportBtn').click(function(event) {
        event.preventDefault();
        var selectedFieldNames = [];

        $('#quickFieldsTable tbody tr').each(function() {
            var fieldName = $(this).find('td[data-field-name]').data('field-name');
            if (fieldName) {
                selectedFieldNames.push(fieldName);
            }

            var fieldOption = $(this).find('input[name="' + fieldName + '_filter_type"]:checked').val();
            var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
            // Adjusted to support combobox. Check if it's a select input and get the value accordingly.
            var value = $(this).find('select[name="' + fieldName + '_value"]').length > 0 ? $(this).find('select[name="' + fieldName + '_value"]').val() : $(this).find('input[name="' + fieldName + '_value"]').val();
            var from = $(this).find('input[id="' + fieldName + '_from"]').val();
            var to = $(this).find('input[id="' + fieldName + '_to"]').val();

            quickExportFilters[fieldName] = { fieldOption, operator, value, from, to };
        });

        $.ajax({
            url: "{{ route('admin.fetch-filtered-data-for-quick-export') }}",
            type: 'POST',
            data: { filters: quickExportFilters },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                var tableHtml = '<div class="table-responsive"><table class="table table-bordered"><thead><tr>';
                if (response.length > 0) {
                    var firstItem = response[0];
                    for (var column in firstItem) {
                        tableHtml += `<th>${column.replace(/_/g, ' ').toUpperCase()}</th>`;
                    }
                }
                tableHtml += '</tr></thead><tbody>';
                response.forEach(function(item) {
                    tableHtml += '<tr>';
                    for (var column in item) {
                        tableHtml += `<td>${item[column] || ''}</td>`;
                    }
                    tableHtml += '</tr>';
                });
                tableHtml += '</tbody></table></div>';
                $('#dynamicExcelPreviewModal .modal-body').html(tableHtml);
                $('#dynamicExcelPreviewModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: ", error);
            }
        });
    });
    $('input[name="quickExportOption"]').change(function() {
        var quickExportOption = $(this).val();
        $('input[name="quickExportOption"][type="hidden"]').val(quickExportOption);
    });

    // $('#btnQuickExport').click(function(event) {
    //     event.preventDefault(); // Prevent the default form submission behavior

    //     var quickExportOption = $('input[name="quickExportOption"]:checked').val() || 'default';
    //     console.log('quickExportFilters:', quickExportFilters);

    //     var selectedFieldNames = [];
    //     $('#quickFieldsTable tbody tr').each(function() {
    //         var fieldName = $(this).find('td[data-field-name]').data('field-name');
    //         if (fieldName) {
    //             selectedFieldNames.push(fieldName);
    //             var fieldOption = $(this).find('input[name="' + fieldName + '_filter_type"]:checked').val();
    //             var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
    //             var value = $(this).find('input[name="' + fieldName + '_value"]').val();
    //             var from = $(this).find('input[id="' + fieldName + '_from"]').val();
    //             var to = $(this).find('input[id="' + fieldName + '_to"]').val();

    //             quickExportFilters[fieldName] = { fieldOption, operator, value, from, to };
    //         }
    //     });

    //     if (selectedFieldNames.length === 0) {
    //         toastr.error('No fields selected for custom export.');
    //         return;
    //     }

    //     if (quickExportOption === 'custom') {
    //         // Send AJAX request for custom quick export
    //         // Send AJAX request for custom quick export
    //         $.ajax({
    //             url: "{{ route('admin.export') }}",
    //             type: 'POST',
    //             data: JSON.stringify({
    //                 _token: $('meta[name="csrf-token"]').attr('content'),
    //                 export_type: 'quick',
    //                 quickExportOption: quickExportOption,
    //                 selected_fields: selectedFieldNames, // Ensure this is correctly populated
    //                 filters: quickExportFilters
    //             }),
    //             contentType: "application/json",
    //             xhrFields: {
    //                 responseType: 'blob'
    //             },
    //             success: function(response) {
    //                 var blob = new Blob([response]);
    //                 var link = document.createElement('a');
    //                 link.href = window.URL.createObjectURL(blob);
    //                 link.download = 'loans_quick_custom_export.xlsx';
    //                 link.click();
    //             },
    //             error: function(xhr, status, error) {
    //                 toastr.error('An error occurred while processing the export: ' + error);
    //             }
    //         });
    //     } 
    //     // else {
    //     //     // Send AJAX request for default quick export
    //     //     $.ajax({
    //     //         url: "{{ route('admin.export') }}",
    //     //         type: 'POST',
    //     //         data: {
    //     //             export_type: 'quick',
    //     //             quickExportOption: quickExportOption,
    //     //             selected_fields: selectedFieldNames, // Ensure this is correctly populated
    //     //             _token: $('meta[name="csrf-token"]').attr('content')
    //     //         },
    //     //         contentType: "application/json",
    //     //         xhrFields: {
    //     //             responseType: 'blob'
    //     //         },
    //     //         success: function(response) {
    //     //             var blob = new Blob([response]);
    //     //             var link = document.createElement('a');
    //     //             link.href = window.URL.createObjectURL(blob);
    //     //             link.download = 'loans_quick_default_export.xlsx';
    //     //             link.click();
    //     //         },
    //     //         error: function() {
    //     //             toastr.error('An error occurred while processing the export.');
    //     //         }
    //     //     });
    //     // }
    // });

    $('.visibleExportBtn').click(function(event) {
        event.preventDefault();
        event.stopPropagation();

        var quickExportOption = $('input[name="quickExportOption"]:checked').val();
        // console.log('Export Option:', quickExportOption);
        // console.log('Number of fields:', $('#quickFieldsTable tbody tr').length);

        if (quickExportOption === 'custom' && !$('#quickFieldsTable tbody tr').length) {
            toastr.error('No fields selected for custom export.');
            return;
        }

        var selectedFieldNames = $('#quickFieldsTable tbody tr').map(function() {
            return $(this).find('td[data-field-name]').data('field-name');
        }).get();

        var quickExportFilters = {};

        
        var exportData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            export_type: 'quick',
            quickExportOption: quickExportOption,
            selected_fields: selectedFieldNames,
            filters: {}
        };

        $('#quickFieldsTable tbody tr').each(function() {
            var fieldName = $(this).find('td[data-field-name]').data('field-name');
            var filterType = $(this).find('input[name="' + fieldName + '_filter_type"]:checked').val();

            if (fieldName === 'loan_type' || fieldName === 'remarks' || fieldName === 'application_status') {
                var value = $(this).find('select[name="' + fieldName + '_value"]').val();
                exportData.filters[fieldName] = {
                    value: value
                };
            } else if (filterType !== 'no_filter') {
                var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
                var value = $(this).find('input[name="' + fieldName + '_value"]').val();
                var from = $(this).find('input[id="' + fieldName + '_from"]').val();
                var to = $(this).find('input[id="' + fieldName + '_to"]').val();

                exportData.filters[fieldName] = {
                    fieldOption: filterType,
                    operator: operator,
                    value: value,
                    from: from,
                    to: to
                };
            }
        });

        // console.log('Export Data:', exportData);

        $.ajax({
            url: "{{ route('admin.export') }}",
            type: 'POST',
            data: JSON.stringify(exportData),
            contentType: "application/json",
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'loans_quick_custom_export.xlsx';
                link.click();
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while processing the export: ' + error);
            }
        });
    });

    $('#btnQuickExport').click(function(event) {
        event.preventDefault(); // Prevent form submission
        var quickExportOption = $('input[name="quickExportOption"]:checked').val() || 'default';

        console.log('Export Option:', quickExportOption); // Debugging log
        console.log('Number of fields:', $('#quickFieldsTable tbody tr').length); // Debugging log

        if (quickExportOption === 'custom' && !$('#quickFieldsTable tbody tr').length) {
            toastr.error('No fields selected for custom export.');
            console.log('Prevention triggered'); // Debugging log
            return;
        }

        // Prepare data for AJAX request
        var exportData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            export_type: 'quick',
            quickExportOption: quickExportOption
        };

        if (quickExportOption === 'custom') {
            exportData.selected_fields = $('#quickFieldsTable tbody tr').map(function() {
                return $(this).find('td[data-field-name]').data('field-name');
            }).get();
            exportData.filters = collectFilters();
        }

        console.log('Export Data:', exportData); // Debugging log

        // Send AJAX request
        $.ajax({
            url: "{{ route('admin.export') }}",
            type: 'POST',
            data: JSON.stringify(exportData),
            contentType: "application/json",
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'export.xlsx'; // Adjust the filename as needed
                link.click();
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred while processing the export: ' + error);
            }
        });
    });

    function collectFilters() {
        var filters = {};
        $('#quickFieldsTable tbody tr').each(function() {
            var fieldName = $(this).find('td[data-field-name]').data('field-name');
            filters[fieldName] = {
                fieldOption: $(this).find('input[name="' + fieldName + '_filter_type"]:checked').val(),
                operator: $(this).find('select[name="' + fieldName + '_operator"]').val(),
                value: $(this).find('input[name="' + fieldName + '_value"]').val(),
                from: $(this).find('input[id="' + fieldName + '_from"]').val(),
                to: $(this).find('input[id="' + fieldName + '_to"]').val()
            };
        });
        return filters;
    }
});
</script>
@endsection

