<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Generate Sertifikat</title>
</head>
<body>
    <h1>Form Pembuatan Sertifikat</h1>
    <form action="{{ route('certificate.store') }}" method="POST">
        @csrf
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required><br><br>
    
        <label for="course">Kursus:</label>
        <input type="text" id="course" name="course" required><br><br>
        
        <label for="course_code">Kode Kursus:</label>
        <input type="text" id="course_code" name="course_code" required placeholder="Masukkan Kode Kursus"><br><br>
    
        <label for="duration">Durasi Pelatihan:</label>
        <input type="text" id="duration" name="duration" required><br><br>
    
        <label for="date">Tanggal:</label>
        <input type="date" id="date" name="date" required><br><br>
    
        <label for="credential_number">Nomor Credential:</label>
        <input type="text" id="credential_number" name="credential_number" required placeholder="Nomor Credential/Kode Course/E-learning-Bosowa/TahunCredential"><br><br>

        <button type="submit">Generate Sertifikat</button>
    </form>
</body>
</html>
