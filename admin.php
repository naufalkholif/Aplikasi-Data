<?php
require_once 'config/database.php';
require_once 'functions/mahasiswa_functions.php';

$message = '';
$message_type = '';

// Proses CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'tambah':
                $data = [
                    'nim' => $_POST['nim'],
                    'nama' => $_POST['nama'],
                    'alamat' => $_POST['alamat'],
                    'tanggal_lahir' => $_POST['tanggal_lahir'],
                    'gender' => $_POST['gender']
                ];
                
                $validasi = validasiDataMahasiswa($data);
                
                if ($validasi['valid']) {
                    if (tambahMahasiswa($conn, $data)) {
                        $message = "✅ Data mahasiswa berhasil ditambahkan!";
                        $message_type = "success";
                    } else {
                        $message = "❌ Gagal menambahkan data: " . mysqli_error($conn);
                        $message_type = "danger";
                    }
                } else {
                    $message = "❌ " . implode("<br>", $validasi['errors']);
                    $message_type = "danger";
                }
                break;
                
            case 'update':
                $id = $_POST['id'];
                $data = [
                    'nama' => $_POST['nama'],
                    'alamat' => $_POST['alamat'],
                    'tanggal_lahir' => $_POST['tanggal_lahir'],
                    'gender' => $_POST['gender']
                ];
                
                if (updateMahasiswa($conn, $id, $data)) {
                    $message = "✅ Data mahasiswa berhasil diupdate!";
                    $message_type = "success";
                } else {
                    $message = "❌ Gagal mengupdate data: " . mysqli_error($conn);
                    $message_type = "danger";
                }
                break;
                
            case 'hapus':
                $id = $_POST['id'];
                if (hapusMahasiswa($conn, $id)) {
                    $message = "✅ Data mahasiswa berhasil dihapus!";
                    $message_type = "success";
                } else {
                    $message = "❌ Gagal menghapus data: " . mysqli_error($conn);
                    $message_type = "danger";
                }
                break;
        }
    }
}

$edit_data = isset($_GET['edit']) ? getMahasiswaById($conn, $_GET['edit']) : null;
$data_mahasiswa = getAllMahasiswa($conn);

include 'includes/header.php';
?>

<!-- Hero Section -->
<div class="row mb-5" data-aos="fade-down">
    <div class="col-12 text-center">
        <h1 class="display-4 fw-bold text-white mb-3">
            <i class="fas fa-cog me-3"></i>Panel Admin
        </h1>
        <p class="lead text-white opacity-75">
            Kelola data mahasiswa dengan mudah
        </p>
    </div>
</div>

<!-- Alert Message -->
<?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert" data-aos="fade-up">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="card mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas <?php echo $edit_data ? 'fa-edit' : 'fa-plus-circle'; ?> me-2"></i>
        <?php echo $edit_data ? 'Edit Data Mahasiswa' : 'Tambah Data Mahasiswa'; ?>
    </div>
    <div class="card-body">
        <form method="POST" action="admin.php" class="row g-4">
            <input type="hidden" name="action" value="<?php echo $edit_data ? 'update' : 'tambah'; ?>">
            
            <?php if ($edit_data): ?>
                <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
            <?php endif; ?>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-hashtag me-2 text-primary"></i>NIM
                </label>
                <input type="text" class="form-control" name="nim" 
                       value="<?php echo $edit_data ? htmlspecialchars($edit_data['nim']) : ''; ?>" 
                       <?php echo $edit_data ? 'readonly' : 'required'; ?>
                       placeholder="Contoh: 202401001">
                <?php if ($edit_data): ?>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>NIM tidak dapat diubah
                    </small>
                <?php endif; ?>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                </label>
                <input type="text" class="form-control" name="nama" 
                       value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama']) : ''; ?>" 
                       required placeholder="Masukkan nama lengkap">
            </div>
            
            <div class="col-12">
                <label class="form-label">
                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>Alamat
                </label>
                <textarea class="form-control" name="alamat" rows="3" required 
                          placeholder="Masukkan alamat"><?php echo $edit_data ? htmlspecialchars($edit_data['alamat']) : ''; ?></textarea>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Tanggal Lahir
                </label>
                <input type="date" class="form-control" name="tanggal_lahir" 
                       value="<?php echo $edit_data ? $edit_data['tanggal_lahir'] : ''; ?>" 
                       required>
            </div>
            
            <div class="col-md-6">
                <label class="form-label">
                    <i class="fas fa-venus-mars me-2 text-primary"></i>Gender
                </label>
                <div class="d-flex gap-4 mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Laki-laki" 
                               id="genderLaki" <?php echo ($edit_data && $edit_data['gender'] == 'Laki-laki') ? 'checked' : ''; ?> required>
                        <label class="form-check-label" for="genderLaki">
                            <i class="fas fa-male text-primary me-1"></i> Laki-laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="Perempuan" 
                               id="genderPerempuan" <?php echo ($edit_data && $edit_data['gender'] == 'Perempuan') ? 'checked' : ''; ?> required>
                        <label class="form-check-label" for="genderPerempuan">
                            <i class="fas fa-female text-danger me-1"></i> Perempuan
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <hr>
                <button type="submit" class="btn btn-custom btn-primary-custom px-5">
                    <i class="fas <?php echo $edit_data ? 'fa-save' : 'fa-plus-circle'; ?> me-2"></i>
                    <?php echo $edit_data ? 'Update Data' : 'Simpan Data'; ?>
                </button>
                <?php if ($edit_data): ?>
                    <a href="admin.php" class="btn btn-secondary px-4">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                <?php endif; ?>
                <button type="reset" class="btn btn-warning px-4">
                    <i class="fas fa-redo me-2"></i>Reset
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Data List Card -->
<div class="card" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header">
        <i class="fas fa-list me-2"></i> Daftar Data Mahasiswa
        <span class="badge bg-light text-dark float-end">
            <i class="fas fa-database me-1"></i> <?php echo count($data_mahasiswa); ?> Data
        </span>
    </div>
    <div class="card-body">
        <?php if (count($data_mahasiswa) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Gender</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_mahasiswa as $mhs): ?>
                        <tr>
                            <td><span class="badge-nim"><?php echo htmlspecialchars($mhs['nim']); ?></span></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($mhs['nama']); ?></td>
                            <td><i class="fas fa-map-marker-alt me-1 text-primary"></i><?php echo htmlspecialchars($mhs['alamat']); ?></td>
                            <td>
                                <?php if ($mhs['gender'] == 'Laki-laki'): ?>
                                    <span class="badge-gender badge-laki">
                                        <i class="fas fa-male me-1"></i> Laki-laki
                                    </span>
                                <?php else: ?>
                                    <span class="badge-gender badge-perempuan">
                                        <i class="fas fa-female me-1"></i> Perempuan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="admin.php?edit=<?php echo $mhs['id']; ?>" 
                                   class="btn btn-sm btn-warning" 
                                   data-bs-toggle="tooltip" 
                                   title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" 
                                        onclick="konfirmasiHapus(<?php echo $mhs['id']; ?>, '<?php echo htmlspecialchars($mhs['nama']); ?>')"
                                        data-bs-toggle="tooltip" 
                                        title="Hapus Data">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-database"></i>
                <h4 class="text-muted">Belum ada data mahasiswa</h4>
                <p>Silakan tambah data menggunakan form di atas.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Hidden Form for Delete -->
<form id="form-hapus" method="POST" action="admin.php" style="display: none;">
    <input type="hidden" name="action" value="hapus">
    <input type="hidden" name="id" id="hapus-id">
</form>

<?php
include 'includes/footer.php';
closeConnection($conn);
?>