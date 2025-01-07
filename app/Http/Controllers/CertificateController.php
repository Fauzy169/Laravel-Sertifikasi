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
        // Ambil nilai kode kursus
        $course_code = $request->course_code;

        // Jika kode kursus tidak ada, ganti spasi dalam nama kursus dengan tanda minus
        if (!$course_code) {
            $course_code = str_replace(' ', '-', $request->course);
        }

        // Menambahkan credential_number menggunakan course_code yang sudah diubah
        $request->merge([
            'credential_number' => "{$request->credential_number}/{$course_code}/E-learning-Bosowa/" . date('Y', strtotime($request->date)),
        ]);

        $certificate = Certificate::create($request->validate([
            'name' => 'required|string',
            'course' => 'required|string',
            'course_code' => 'required|string',
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

        // Penyesuaian Nama Peserta
        $max_width = 150; // Lebar maksimal untuk nama peserta
        $font_size = 50;  // Ukuran font awal

        // Cek panjang nama peserta dengan font ukuran 50
        $pdf->SetFont('CrimsonText-BoldItalic', '', $font_size);
        $pdf->SetXY(0, 87);
        $text_width = $pdf->GetStringWidth($certificate->name);

        // Jika nama masih terlalu panjang, kecilkan ukuran font menjadi 40
        if ($text_width > $max_width) {
            $font_size = 30;
            $pdf->SetFont('CrimsonText-BoldItalic', '', $font_size);
            $pdf->SetXY(0, 87);
            $text_width = $pdf->GetStringWidth($certificate->name);

            // Jika nama masih terlalu panjang, bagi menjadi dua baris
            if ($text_width > $max_width) {
                $wrapped_name = wordwrap($certificate->name, 15, "\n");
                $pdf->SetXY(0, 87);
                $pdf->MultiCell(275, 10, $wrapped_name, 0, 'C');
            } else {
                // Nama tetap dalam satu baris dengan font 40
                $pdf->SetXY(0, 87);
                $pdf->Cell(275, 10, $certificate->name, 0, 1, 'C');
            }
        } else {
            // Nama tetap dalam satu baris dengan font 50
            $pdf->SetXY(0, 87);
            $pdf->Cell(275, 10, $certificate->name, 0, 1, 'C');
        }

        // Nama Pelatihan
        $pdf->SetFont('CaviarDreams-Bold', '', 12);
        $pdf->SetXY(0, 114);
        $pdf->Cell(275, 10, $certificate->course, 0, 1, 'C');

        // Durasi Pelatihan
        $pdf->SetFont('CaviarDreams-Regular', '', 12);
        $pdf->SetXY(20, 133);
        $text = "Sertifikat ini diberikan sebagai penghargaan atas keberhasilan dalam menyelesaikan pelatihan ini sebagai peserta yang meliputi {$certificate->duration} pelajaran, dengan penuh dedikasi dan komitmen.";
        $wrappedText = wordwrap($text, 10 * 7, "\n");

        $pdf->MultiCell(235, 6, $wrappedText, 0, 'C');

        // Nomor Credential
        $pdf->SetFont('CaviarDreams-Bold', '', 12);
        $pdf->SetXY(0, 59);
        $pdf->Cell(275, 10, "{$credential_number}", 0, 1, 'C');

        return response($pdf->Output('S', 'certificate.pdf'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="certificate.pdf"');
    }
}
