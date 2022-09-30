<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Lib\Admin\App;

use App\Models\EnquiryModel;

class EnquiryExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithMapping
{
    protected $filter;

    public function __construct($request)
    {
        $this->filter = $request;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $commonconstants = Config('commonconstants');

        $fltrDataArr     = array();
        $perPage         = $commonconstants['pagination_no'];
        $sortBy         = 'enq_id';
        $orderBy         = 'DESC';

        $lstObj = new EnquiryModel;
        $fltrDataArr['name']         = $this->filter['name'] ?? '';
        $fltrDataArr['email']         = $this->filter['email'] ?? '';
        $fltrDataArr['mobile']         = $this->filter['mobile'] ?? '';
        $fltrDataArr['message']      = $this->filter['message'] ?? '';
        $fltrDataArr['created_at']     = $this->filter['created_at'] ?? '';

        $sortBy     = $this->filter['sortBy'] ?? $sortBy;
        $orderBy     = $this->filter['orderBy'] ?? $orderBy;
        $perPage     = $this->filter['perPage'] ?? $perPage;

        return $lstObj::search($fltrDataArr)->orderBy($sortBy, $orderBy)->paginate($perPage);
    }

    public function map($dataModel): array
    {
        return [
            $dataModel->name,
            $dataModel->email,
            $dataModel->mobile,
            $dataModel->message,
            Date::dateTimeToExcel($dataModel->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            __('contact.name_txt'),
            __('contact.email_txt'),
            __('contact.mobile_txt'),
            __('contact.message_txt'),
            __('admin.added_date_txt'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => App::getReportListDataAtr()['dt_tm_report_frmt']
        ];
    }
}
