@php
    $yearFieldName = $yearFieldName ?? 'year';
    $monthFieldName = $monthFieldName ?? 'month';
    $selectedYear = $selectedYear ?? '';
    $selectedMonth = $selectedMonth ?? '';
    $size = $size ?? 6;
    $months = $months ?? range(1, 12);
    $years = $years ?? range((int) now()->format('Y'), 1950);
@endphp

<div class="col-md-{{ $size }}">
    <div class="form_group">
        <select name="{{ $monthFieldName }}" id="{{ $monthFieldName }}" class="select2" required data-placeholder="Select Month">
            <option value="">select month</option>
            @foreach ($months as $m)
                <option value="{{ $m }}" {{ (string) $selectedMonth === (string) $m ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, (int) $m, 10)) }}
                </option>
            @endforeach
        </select>
        @error($monthFieldName)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-md-{{ $size }}">
    <div class="form_group">
        <select name="{{ $yearFieldName }}" id="{{ $yearFieldName }}" class="select2" required data-placeholder="Select Year">
            <option value="">select year</option>
            @foreach ($years as $y)
                <option value="{{ $y }}" {{ (string) $selectedYear === (string) $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endforeach
        </select>
        @error($yearFieldName)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
