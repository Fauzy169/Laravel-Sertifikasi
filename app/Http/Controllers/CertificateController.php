<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class CertificateController extends Controller
{
    public function index()
    {
        return view('certificate.index');
    }

    public function store(Request $request)
    {
        // Menambahkan credential_number
        $request->merge([
            'credential_number' => "E-learning-Bosowa/{$request->course}/" . date('Y', strtotime($request->date)),
        ]);

        $certificate = Certificate::create($request->validate([
            'name' => 'required|string',
            'course' => 'required|string',
            'duration' => 'required|string',
            'date' => 'required|date',
            'credential_number' => 'required|string',
        ]));

        return redirect()->route('certificate.generate', ['id' => $certificate->id]);
    }

    public function generate($id)
    {
        $certificate = Certificate::findOrFail($id);

        // Nomor Credential
        $credential_number = $certificate->credential_number;

        $templatePath = public_path('templates/sertifikat1.pdf');
        $pdf = new FPdi('P', 'mm', [275, 300]); // Ukuran sertifikat
        $pdf->AddPage();
        $pdf->setSourceFile($templatePath);
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0, 275);

        // Tambahkan font
        $pdf->AddFont('CaviarDreams-Bold', '', 'CaviarDreams-Bold.php');
        $pdf->AddFont('CaviarDreams-Regular', '', 'CaviarDreams-Regular.php');
        $pdf->AddFont('CrimsonText-BoldItalic', '', 'CrimsonText-BoldItalic.php');

        // Set warna teks #4D4D4D (RGB: 77, 77, 77)
        $pdf->SetTextColor(77, 77, 77);

        // Nama Peserta
        $pdf->SetFont('CrimsonText-BoldItalic', '', 50);
        $pdf->SetXY(0, 87);
        $pdf->Cell(275, 10, $certificate->name, 0, 1, 'C');

        // Nama Pelatihan
        $pdf->SetFont('CaviarDreams-Bold', '', 12);
        $pdf->SetXY(0, 114);
        $pdf->Cell(275, 10, $certificate->course, 0, 1, 'C');

        // Durasi Pelatihan
        $pdf->SetFont('CaviarDreams-Regular', '', 12);
        $pdf->SetXY(20, 133);
        $text = "Sertifikat ini diberikan sebagai penghargaan atas keberhasilan dalam menyelesaikan pelatihan ini sebagai peserta, dalam jangka waktu {$certificate->duration}, dengan penuh dedikasi dan komitmen.";
        $wrappedText = wordwrap($text, 10 * 7, "\n");

        $pdf->MultiCell(235, 6, $wrappedText, 0, 'C');

        // Nomor Credential
        $pdf->SetFont('CaviarDreams-Bold', '', 12);
        $pdf->SetXY(0, 59);
        $pdf->Cell(275, 10, "Credential: {$credential_number}", 0, 1, 'C');

        return response($pdf->Output('S', 'certificate.pdf'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="certificate.pdf"');
    }
}
