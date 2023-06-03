<div class="modal fade shadow-lg text-left" tabindex="-1" role="dialog" id="modalExcelFilters" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-light">
                <h3>Select the month</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="invoice_status" value="{{ request()->input('invoice_status', 'sent') }}">
                <div class="d-flex">
                    <div class='form-group mr-4 w-168'>
                        <select class="form-control bg-light" name="year"  onchange="document.getElementById('invoiceFilterForm').submit();">
                            <option {{ $filters['year'] == '' ? "selected=selected" : '' }} value="">All Years</option>
                            @php $year = now()->year; @endphp
                            @while ($year != 2015)
                                <option {{ $filters['year'] == $year ? "selected=selected" : '' }} value="{{ $year }}">{{ $year }}</option>
                                @php $year--; @endphp
                            @endwhile
                        </select>
                    </div>

                    <div class='form-group mr-4 w-168'>
                        <select class="form-control bg-light" name="month" onchange="document.getElementById('invoiceFilterForm').submit();">
                            <option {{ $filters['month'] == '' ? "selected=selected" : '' }} value="">All Months</option>
                            <option {{ $filters['month'] == '01' ? "selected=selected" : '' }} value="01">January</option>
                            <option {{ $filters['month'] == '02' ? "selected=selected" : '' }} value="02">February</option>
                            <option {{ $filters['month'] == '03' ? "selected=selected" : '' }} value="03">March</option>
                            <option {{ $filters['month'] == '04' ? "selected=selected" : '' }} value="04">April</option>
                            <option {{ $filters['month'] == '05' ? "selected=selected" : '' }} value="05">May</option>
                            <option {{ $filters['month'] == '06' ? "selected=selected" : '' }} value="06">June</option>
                            <option {{ $filters['month'] == '07' ? "selected=selected" : '' }} value="07">July</option>
                            <option {{ $filters['month'] == '08' ? "selected=selected" : '' }} value="08">August</option>
                            <option {{ $filters['month'] == '09' ? "selected=selected" : '' }} value="09">September</option>
                            <option {{ $filters['month'] == '10' ? "selected=selected" : '' }} value="10">October</option>
                            <option {{ $filters['month'] == '11' ? "selected=selected" : '' }} value="11">November</option>
                            <option {{ $filters['month'] == '12' ? "selected=selected" : '' }} value="12">December</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>