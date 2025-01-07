<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Generate Sertifikat</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="text-center mb-4">Form Pembuatan Sertifikat</h1>
                    <form action="{{ route('certificate.store') }}" method="POST">
                        @csrf
                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <!-- Kursus -->
                        <div class="mb-3">
                            <label for="course" class="form-label">Kursus:</label>
                            <input type="text" id="course" name="course" class="form-control" required>
                        </div>
                        
                        <!-- Kode Kursus -->
                        <div class="mb-3">
                            <label for="course_code" class="form-label">Kode Kursus:</label>
                            <input type="text" id="course_code" name="course_code" class="form-control" required placeholder="Masukkan Kode Kursus">
                        </div>
                        
                        <!-- Durasi Pelatihan -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Durasi Pelatihan:</label>
                            <input type="text" id="duration" name="duration" class="form-control" required>
                        </div>
                        
                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                        
                        <!-- Nomor Credential -->
                        <div class="mb-3">
                            <label for="credential_number" class="form-label">Nomor Credential:</label>
                            <input type="text" id="credential_number" name="credential_number" class="form-control" required placeholder="Nomor Credential/Kode Course/E-learning-Bosowa/TahunCredential">
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Generate Sertifikat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional, for interactive components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
