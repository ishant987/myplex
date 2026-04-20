<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('printNoData')) {
    function printNoData(): string
    {
        return '<div class="alert alert-warning text-center my-3">No data available.</div>';
    }
}

if (!function_exists('printValue')) {
    function printValue($value): string
    {
        if ($value === null || $value === '') {
            return 'N/A';
        }

        if (!is_numeric($value)) {
            return (string) $value;
        }

        $formatted = number_format((float) $value, 2, '.', '');

        return rtrim(rtrim($formatted, '0'), '.');
    }
}

if (!function_exists('getNameTable')) {
    function getNameTable(string $table, string $selectField, string $whereField, $whereValue)
    {
        if ($whereValue === null || $whereValue === '') {
            return '';
        }

        try {
            return DB::table($table)->where($whereField, $whereValue)->value($selectField) ?? '';
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (!function_exists('getNameTableMultiple')) {
    function getNameTableMultiple(
        string $table,
        string $selectField,
        string $whereField,
        $whereValue,
        string $extraWhereField,
        $extraWhereValue
    ) {
        if ($whereValue === null || $whereValue === '') {
            return '';
        }

        try {
            return DB::table($table)
                ->where($whereField, $whereValue)
                ->where($extraWhereField, $extraWhereValue)
                ->value($selectField) ?? '';
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (!function_exists('printRank')) {
    function printRank($value): string
    {
        if ($value === null || $value === '' || $value === 'N/A' || !is_numeric($value)) {
            return 'N/A';
        }

        return (string) (int) $value;
    }
}

if (!function_exists('custom_sort')) {
    function custom_sort(array $input, bool $ascending = true): array
    {
        $numeric = [];
        $nonNumeric = [];

        foreach ($input as $key => $value) {
            if (is_numeric($value)) {
                $numeric[$key] = $value;
            } else {
                $nonNumeric[$key] = $value;
            }
        }

        if ($ascending) {
            asort($numeric, SORT_NUMERIC);
        } else {
            arsort($numeric, SORT_NUMERIC);
        }

        return $numeric + $nonNumeric;
    }
}
