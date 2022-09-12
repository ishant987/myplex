<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Validator;

use App\Models\CurrencyDetail;

class MissingCurrencyImport implements ToCollection, WithHeadingRow
{
    private $rows = 0;
    private $entryExistArr = array();

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        $commonconstants = Config('commonconstants');

        $loginAdminId = auth()->guard('admin')->user()->admin_id;
        $yVal = $commonconstants['y_n_val'][1];

        $cellRow = $this->headingRow();
        foreach ($rows as $key => $row) {
            ++$cellRow;
            $input = $row->toArray();
            $rulesArr = [
                'missing_date' => 'required',
                'currency_id' => 'required',
                'value' => 'required'
            ];
            $rulesMsgsArr = [
                'missing_date.required' => 'The row(' . $cellRow . '): missing date field is required.',
                'currency_id.required' => 'The row(' . $cellRow . '): currency id field is required.',
                'value.required' => 'The row(' . $cellRow . '): value field is required.'
            ];

            Validator::make($input, $rulesArr, $rulesMsgsArr)->validate();

            $dataExist = CurrencyDetail::where(['entry_date' => trim($input['missing_date']), 'cm_id' => trim($input['currency_id'])])->first();
            if ($dataExist) {
                $this->entryExistArr[] = $input['missing_date'];
            } else {
                ++$this->rows;

                $store = new CurrencyDetail;
                $store->cm_id = $input['currency_id'];
                $store->entry_date = $input['missing_date'];
                $store->entry_value = $input['value'];
                $store->publish = $yVal;
                $store->created_id = $loginAdminId;
                $store->updated_id = $loginAdminId;
                $store->save();
            }
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getEntryExistArr(): array
    {
        return $this->entryExistArr;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function startRow(): int
    {
        return 2;
    }
}
