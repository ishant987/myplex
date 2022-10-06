<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Validator;

use App\Models\IndicesDetail;

class MissingIndicesImport implements ToCollection, WithHeadingRow
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
                'index_corelation' => 'required',
                'value' => 'required'
            ];
            $rulesMsgsArr = [
                'missing_date.required' => 'The row(' . $cellRow . '): missing date field is required.',
                'index_corelation.required' => 'The row(' . $cellRow . '): index corelation field is required.',
                'value.required' => 'The row(' . $cellRow . '): value field is required.'
            ];

            Validator::make($input, $rulesArr, $rulesMsgsArr)->validate();

            $dataExist = IndicesDetail::where(['entry_date' => trim($input['missing_date']), 'name' => trim($input['index_corelation'])])->first();
            if ($dataExist) {
                $this->entryExistArr[] = $input['missing_date'];
            } else {
                ++$this->rows;

                $last = IndicesDetail::getClosingValue($input['index_corelation'], $input['missing_date']);
                if ($last == 0) {
                    $percentageChange = 0;
                } else {
                    $percentageChange = (($input['value'] - $last) / $last) * 100;
                }

                $store = new IndicesDetail;
                $store->name = $input['index_corelation'];
                $store->entry_date = $input['missing_date'];
                $store->closing_value = $input['value'];
                $store->percentage_change = $percentageChange;
                $store->holiday = intval($input['holiday']);
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
