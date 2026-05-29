@php
    $years = range(Carbon\Carbon::now()->year, Carbon\Carbon::now()->year - 4);
    // sort($years);
@endphp

<div class="col-md-{{ $size ?? 4 }}">
    <div class="form_group">
        <select name="{{ $yearFieldName }}" id="dynamic_year" required>
            <option value="">Select Year</option>
            @foreach ($years as $yearValue)
            <option value="{{ $yearValue }}" {{ old($yearFieldName, isset($selectedYear) && $selectedYear == $yearValue) ? 'selected' : '' }}>{{ $yearValue }}</option>            
            @endforeach
        </select>
    </div>
</div>


<div class="col-md-{{ $size ?? 4 }}">
    <div class="form_group">
        <select name="{{ $monthFieldName }}" id="dynamic_month" required {{ empty($selectedYear) ? 'disabled' : '' }}>
            <option value="">Select Month</option>
            @if ($selectedYear)
                @php
                    $currentYear = date('Y');
                    $currentMonth = date('n');
                @endphp
                @foreach (range(1, 12) as $monthValue)
                    @if ($selectedYear < $currentYear || ($selectedYear == $currentYear && $monthValue < $currentMonth))
                        <option value="{{ $monthValue }}"
                            {{ old($monthFieldName, isset($selectedMonth) && $selectedMonth == $monthValue) ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $monthValue)->format('F') }}
                        </option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
</div>

