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
                                                    'id', 'account_number', 'customer_name', 'age', 'birth_date', 'date_employed',
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
                                    @csrf
                                    <div class="form-group">
                                        <label for="fieldSelection">Add Fields:</label>
                                        <select class="form-control" id="fieldSelection">
                                            <option value="">Select a field</option>
                                            @php
                                                $fields = [
                                                    'id', 'loan_reference', 'customer_name', 'age', 'birth_date', 'date_employed', 
                                                    'contact_num', 'college', 'taxid_num', 'loan_type', 'work_position', 
                                                    'retirement_year', 'application_date', 'time_pay', 'application_status', 
                                                    'financed_amount', 'monthly_pay', 'finance_charge', 'balance', 'note', 
                                                    'due_date', 'remarks', 'created_at'
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
                                                <th>Field Name</th>
                                                <th>Option</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Rows will be added here dynamically -->
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <input type="hidden" name="export_type" value="custom">
                    <button type="submit" id="btnCustomExport" class="btn btn-success d-none">Export</button>
                </div>
                <div id="selectedFieldsContainer"></div>
                <div class="mt-3">
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
<script>
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('.visibleExportBtn').click(function() {
        // Programmatically click the hidden submit button inside the form
        $('#btnQuickExportForm').click();
    });

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

    const fieldsWithCustomRange = [
        'retirement_year', 'application_date', 'time_pay', 'application_status', 
        'financed_amount', 'monthly_pay', 'finance_charge', 'balance', 'note', 
        'due_date', 'remarks', 'created_at', 'loan_type', 'work_position', 
        'college', 'age', 'date_employed', 'birth_date'
    ];
    const numericalFields = ['monthly_pay', 'finance_charge', 'balance', 'financed_amount', 'age'];
    const dateFields = ['date_employed', 'due_date', 'application_date', 'created_at', 'birth_date'];

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
            case 'retirement_year':
                customInputsHtml = `
                    <td>
                        <div class="d-flex gap-2">
                            <div>
                                <label for="${selectedField}_from">From:</label>
                                <input type="number" class="form-control" id="${selectedField}_from" name="${selectedField}_from">
                            </div>
                            <div>
                                <label for="${selectedField}_to">To:</label>
                                <input type="number" class="form-control" id="${selectedField}_to" name="${selectedField}_to">
                            </div>
                        </div>
                    </td>
                `;
                break;
            case 'taxid_num':
            case 'age':
            case 'account_number':
            case 'college':
            case 'customer_name':
            case 'work_position':
                customInputsHtml = `
                    <td>
                        <input type="text" class="form-control" name="${selectedField}_value" placeholder="Enter ${selectedField.replace('_', ' ')}">
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
        $('#fieldsTable tbody').append(newRow);

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

        $('#fieldSelection').val(''); // Reset the dropdown
    });

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
            case 'retirement_year':
                customInputsHtml = `
                    <td>
                        <div class="d-flex gap-2">
                            <div>
                                <label for="${selectedField}_from">From:</label>
                                <input type="number" class="form-control" id="${selectedField}_from" name="${selectedField}_from">
                            </div>
                            <div>
                                <label for="${selectedField}_to">To:</label>
                                <input type="number" class="form-control" id="${selectedField}_to" name="${selectedField}_to">
                            </div>
                        </div>
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
                        <input type="text" class="form-control" name="${selectedField}_value" placeholder="Enter ${selectedFieldName}">
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
        $(this).closest('tr').remove();
    });

    $('#btnCustomExport').click(function() {
        $('#exportForm input[type="hidden"]').not('[name="_token"], [name="export_type"]').remove();

        $('#fieldsTable tbody tr').each(function() {
            var fieldName = $(this).find('td[data-field-name]').data('field-name');
            var fieldOption = $(this).find('input[name="' + fieldName + '_option"]:checked').val();
            var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
            var value = $(this).find('input[name="' + fieldName + '_value"]').val();
            var from = $(this).find('input[id="' + fieldName + '_from"]').val();
            var to = $(this).find('input[id="' + fieldName + '_to"]').val();

            $('#exportForm').append(`<input type="hidden" name="selected_fields[]" value="${fieldName}">`);
            $('#exportForm').append(`<input type="hidden" name="${fieldName}_option" value="${fieldOption}">`);

            if (operator) {
                $('#exportForm').append(`<input type="hidden" name="${fieldName}_operator" value="${operator}">`);
                $('#exportForm').append(`<input type="hidden" name="${fieldName}_value" value="${value}">`);
            }
            if (from && to) {
                $('#exportForm').append(`<input type="hidden" name="${fieldName}_from" value="${from}">`);
                $('#exportForm').append(`<input type="hidden" name="${fieldName}_to" value="${to}">`);
            }
        });

        $('#exportForm').submit();
    });

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
                var tableHtml = '<div class="table-responsive" style="max-height: 400px; overflow-y: auto; overflow-x: auto;"><table class="table table-bordered"><thead><tr>';

                // Generate column headers for all columns
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

    $('#btnQuickExport').click(function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    console.log('quickExportFilters:', quickExportFilters);

    var selectedFieldNames = [];
    if ($('input[name="quickExportOption"]:checked').val() === 'custom') {
        $('#quickFieldsTable tbody tr').each(function() {
            var fieldName = $(this).find('td[data-field-name]').data('field-name');
            if (fieldName) {
                selectedFieldNames.push(fieldName);
            }

            var fieldOption = $(this).find('input[name="' + fieldName + '_filter_type"]:checked').val();
            var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
            var value = $(this).find('input[name="' + fieldName + '_value"]').val();
            var from = $(this).find('input[id="' + fieldName + '_from"]').val();
            var to = $(this).find('input[id="' + fieldName + '_to"]').val();

            quickExportFilters[fieldName] = { fieldOption, operator, value, from, to };
        });

        // Send AJAX request for custom quick export
        $.ajax({
            url: "{{ route('admin.export') }}",
            type: 'POST',
            data: {
                export_type: 'quick',
                quickExportOption: 'custom',
                filters: quickExportFilters,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'loans_quick_custom_exportss.xlsx';
                link.click();
            },
            error: function() {
                toastr.error('An error occurred while processing the export.');
            }
        });
    } else {
        // Send AJAX request for default quick export
        $.ajax({
            url: "{{ route('admin.export') }}",
            type: 'POST',
            data: {
                export_type: 'quick',
                quickExportOption: 'default',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
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
            error: function() {
                toastr.error('An error occurred while processing the export.');
            }
        });
    }
});

$('#dynamicExcelPreviewBtn').click(function(event) {
    event.preventDefault();

    var filters = {};
    var selectedFieldNames = [];

    $('#fieldsTable tbody tr').each(function() {
        var fieldName = $(this).find('td[data-field-name]').data('field-name');
        var fieldOption = $(this).find('input[name="' + fieldName + '_option"]:checked').val();
        var operator = $(this).find('select[name="' + fieldName + '_operator"]').val();
        var value = $(this).find('input[name="' + fieldName + '_value"]').val() || $(this).find('select[name="' + fieldName + '_value"]').val(); // Adjusted to support combobox
        var from = $(this).find('input[id="' + fieldName + '_from"]').val();
        var to = $(this).find('input[id="' + fieldName + '_to"]').val();

        // Populate the filters object for AJAX request
        filters[fieldName] = { fieldOption, operator, value, from, to };

        // Append selected field names for table headers
        selectedFieldNames.push(fieldName);
    });

    $.ajax({
        url: '/admin/fetch-filtered-data',
        type: 'POST',
        data: { filters: filters }, // Now sending the populated filters object
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
                    tableHtml += `<td>${item[fieldName] || ''}</td>`;
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
});
</script>
@endsection

