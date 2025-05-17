<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use setasign\Fpdi\Tcpdf\Fpdi;

class BubbleSheetController extends Controller
{

    // setting the path of the template.
    const TEMPLATE_PATH = 'temps/bubble-sheet.pdf';

    // The UI Design to upload the excel file.
    public function showUploadForm()
    {
        return view('upload');
    }

    public function processExcel(Request $request)
    {

        // ensure that the uploaded file is an excel file.
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls'
        ]);

        try {

            // Receiving the excel file to extract student data.
            $data = Excel::toArray([], $request->file('excel'))[0];
            array_shift($data); // remove header row

            // set the path of the pdf template (Bubble Sheet).
            $templatePath = storage_path('app/' . self::TEMPLATE_PATH);
            // check if the path is correct or not
            if (!file_exists($templatePath)) {
                throw new \Exception("Template file not found at: " . $templatePath);
            }


             // Generating a new PDF
            $pdf = new Fpdi();
            // Breaking pages to make a single page (bubble sheet) for each student.
            $pdf->SetAutoPageBreak(false);
            // No header, No footer for each page.
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Amiri font supports Arabic and UTF-8 encoding.
            $pdf->SetFont('amiri', '', 13.3);


            // Extracting student data from the excel file.
            foreach ($data as $row) {
                $student = [
                    'name' => $row[3] ?? '',
                    'program' => $row[4] ?? '',
                    'course' => $row[5] ?? '',
                    'level' => $row[6] ?? '',
                    'academic_number' => $row[1] ?? ''
                ];

                // add a new bubble sheet page.
                $pdf->AddPage();

                // Set the source file each time before importing page
                $pdf->setSourceFile($templatePath);
                // importing the template from the storage.
                $templateId = $pdf->importPage(1);
                // using template to generate bubble sheets.
                $pdf->useTemplate($templateId);

                // filling the bubble sheet with the selected data.
                $this->fillStudentData($pdf, $student);
            }


            // naming the final PDF file which contains all bubble sheets.
            $filename = 'bubble_sheets_' . now()->format('Y-m-d_H-i-s') . '.pdf';

            // streaming the PDF to the client.
            return response($pdf->Output($filename, 'I'), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    protected function fillStudentData(Fpdi $pdf, array $student)
    {
        // Coordinates must match your template layout
        $fields = [
            'name' => ['x' => 120, 'y' => 20],
            'program' => ['x' => 78, 'y' => 22],
            'course' => ['x' => 78, 'y' => 30],
            'level' => ['x' => 22, 'y' => 22],
            'academic_number' => ['x' => 160, 'y' => 28.6]
        ];

        // putting the data in the correct position with X,Y axis.
        foreach ($fields as $key => $position) {
            $pdf->SetXY($position['x'], $position['y']);
            $text = $student[$key] ?? '';
            $pdf->Cell(0, 10, $text, 0, 1, 'L', false, '', 0, false, 'T', 'M');
        }


        // Generate a barcode by the academic number (unique for each student)
        if (!empty($student['academic_number'])) {
            $barcodeX = 150;
            $barcodeY = 40;

            $pdf->write1DBarcode(
                $student['academic_number'],
                'C128',        // Barcode type: Code 128
                $barcodeX,     // X position
                $barcodeY,     // Y position
                '',
                '',        // Width/Height (auto)
                0.4,           // Line width
                ['position' => '', 'align' => 'C', 'stretch' => false, 'fitwidth' => true, 'cellfitalign' => ''], // style
                'N'
            );
        }
    }
}
