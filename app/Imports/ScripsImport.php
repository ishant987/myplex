<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

use Validator;

use App\Models\Scrips;

class ScripsImport implements ToCollection, WithHeadingRow
{
    private $rows = 0;
    private $updRows = 0;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        $loginAdminId = auth()->guard('admin')->user()->admin_id;

        $cellRow = $this->headingRow();
        foreach ($rows as $key => $row) {
            ++$cellRow;
            $input = $row->toArray();
            $rulesArr = [
                'scrip_name' => 'required',
                // 'scrip_name' => 'required|unique:scrips',
                'type' => 'required',
                'industry' => 'required',
                'actual_scrip' => 'required'
            ];
            $rulesMsgsArr = [
                'scrip_name.required' => 'The row(' . $cellRow . '): scrip name field is required.',
                // 'scrip_name.unique' => 'The row(' . $cellRow . '): scrip name already added.',
                'type.required' => 'The row(' . $cellRow . '): type field is required.',
                'industry.required' => 'The row(' . $cellRow . '): industry field is required.',
                'actual_scrip.required' => 'The row(' . $cellRow . '): actual scrip field is required.'
            ];

            Validator::make($input, $rulesArr, $rulesMsgsArr)->validate();

            $inputNew = [
                'scrip_name'     => trim($input['scrip_name']),
                'type'     => trim($input['type']),
                'industry'     => trim($input['industry']),
                'actual_scrip'   => trim($input['actual_scrip'])
            ];

            $store = Scrips::where(['scrip_name' => trim($input['scrip_name'])])->first();
            if ($store) {
                ++$this->updRows;
                foreach ($inputNew as $key => $value) {
                    $store->$key = trim($value);
                }
                $store->updated_id = $loginAdminId;
                $store->save();
            } else {
                ++$this->rows;

                $store = new Scrips;

                foreach ($input as $key => $value) {
                    $store->$key = trim($value);
                }
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

    public function getUpdRowCount(): int
    {
        return $this->updRows;
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
