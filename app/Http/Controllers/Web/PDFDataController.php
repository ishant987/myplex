<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use DB;
use PDF;

class PDFDataController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function compositionSnapshotPDF($type_id)
    {
        $pdf = PDF::loadView('pdf.composition-snapshot');

        return $pdf->stream();
    }
}
