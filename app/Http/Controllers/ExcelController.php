<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ExcelController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'excel' => 'required|file|mimes:xls,xlsx',
        ]);

        $data = Excel::toArray([], $request->file('excel'));
        $rows = $data[0]; // First sheet

       


        return Pdf::loadView('pdf-view', ['rows' => $rows])
            ->stream('students.pdf');
    }
}
