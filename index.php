<?php
require_once 'config/database.php';
require_once 'functions/mahasiswa_functions.php';

$search_keyword = isset($_GET['search']) ? $_GET['search'] : '';
$data_mahasiswa = !empty($search_keyword) ? searchMahasiswaByName($conn, $search_keyword) : getAllMahasiswa($conn);
$statistik = getStatistikGender($conn);

include 'includes/header.php';
?>

<!-- Hero Section -->
<div class="row mb-5" data-aos="fade-down">
    <div class="col-12 text-center">
        <h1 class="display-4 fw-bold text-white mb-3">
            <i class="fas fa-database me-3"></i>Data Mahasiswa
        </h1>
        <p class="lead text-white opacity-75">
            Kelola data mahasiswa dengan mudah dan cepat
        </p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-5" data-aos="fade-up" data-aos-delay="100">
    <div class="col-md-4 mb-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3><?php echo $statistik['total']; ?></h3>
            <p>Total Mahasiswa</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="stat-card male">
            <div class="stat-icon">
                <i class="fas fa-male"></i>
            </div>
            <h3><?php echo $statistik['laki']; ?></h3>
            <p>Laki-laki</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="stat-card female">
            <div class="stat-icon">
                <i class="fas fa-female"></i>
            </div>
            <h3><?php echo $statistik['perempuan']; ?></h3>
            <p>Perempuan</p>
        </div>
    </div>
</div>

<!-- Search Card -->
<div class="card" data-aos="fade-up" data-aos-delay="200">
    <div class="card-header">
        <i class="fas fa-search"></i> Pencarian Data
    </div>
    <div class="card-body">
        <form method="GET" action="index.php">
            <div class="row g-3">
                <div class="col-md-10">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari nama mahasiswa..." 
                               value="<?php echo htmlspecialchars($search_keyword); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-custom btn-primary-custom w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table Card -->
<div class="card mt-4" data-aos="fade-up" data-aos-delay="300">
    <div class="card-header">
        <i class="fas fa-table me-2"></i> Data Mahasiswa
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
                            <th><i class="fas fa-hashtag me-2"></i>NIM</th>
                            <th><i class="fas fa-user me-2"></i>Nama</th>
                            <th><i class="fas fa-map-marker-alt me-2"></i>Alamat</th>
                            <th><i class="fas fa-calendar-alt me-2"></i>Tanggal Lahir</th>
                            <th><i class="fas fa-venus-mars me-2"></i>Gender</th>
                            <th><i class="fas fa-birthday-cake me-2"></i>Usia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_mahasiswa as $mhs): ?>
                        <tr>
                            <td><span class="badge-nim"><?php echo htmlspecialchars($mhs['nim']); ?></span></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($mhs['nama']); ?></td>
                            <td><i class="fas fa-map-marker-alt me-1 text-primary"></i><?php echo htmlspecialchars($mhs['alamat']); ?></td>
                            <td><i class="fas fa-calendar me-1 text-success"></i><?php echo date('d-m-Y', strtotime($mhs['tanggal_lahir'])); ?></td>
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
                                <span class="badge-usia">
                                    <i class="fas fa-birthday-cake me-1"></i> <?php echo $mhs['usia']; ?> tahun
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-frown"></i>
                <h4 class="text-muted">Tidak ada data ditemukan</h4>
                <?php if (!empty($search_keyword)): ?>
                    <p>Maaf, tidak ditemukan mahasiswa dengan nama "<?php echo htmlspecialchars($search_keyword); ?>"</p>
                <?php else: ?>
                    <p>Belum ada data mahasiswa. Silakan tambah data di halaman ADMIN.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include 'includes/footer.php';
closeConnection($conn);
?>