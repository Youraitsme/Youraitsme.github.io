<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "restoran";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database. Pesan error: " . mysqli_connect_error());
}

$nama       = "";
$email       = "";
$subjek     = "";
$pesan   = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from contact where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from contact where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama        = $r1['nama'];
    $email       = $r1['email'];
    $subjek     = $r1['subjek'];
    $pesan   = $r1['pesan'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { // Untuk create atau update
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $subjek = $_POST['subjek'];
    $pesan = $_POST['pesan'];
  
    if ($nama && $email && $subjek && $pesan) {
        if ($op == 'edit') { // Untuk update
            $sql1 = "update contact set nama = '$nama', email='$email', subjek = '$subjek', pesan='$pesan' where id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
                // Mengosongkan kolom formulir setelah pengiriman berhasil
                $nama = "";
                $email = "";
                $subjek = "";
                $pesan = "";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { // Untuk insert
            $sql1 = "insert into contact(nama, email, subjek, pesan) values ('$nama', '$email', '$subjek', '$pesan')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
                // Mengosongkan kolom formulir setelah pengiriman berhasil
                $nama = "";
                $email = "";
                $subjek = "";
                $pesan = "";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ADMIN FORM</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet" />
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
</head>

<body class="bg-white">
      <!-- Navbar & Hero Start -->
      <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
          <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Youra Resto & Cafe</h1>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
              <a href="index.php" class="nav-item nav-link">Home</a>
              <a href="about.html" class="nav-item nav-link">About</a>
              <a href="menu.html" class="nav-item nav-link">Menu</a>
              <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0">
                  <a href="booking.html" class="dropdown-item">Booking</a>
                  <a href="team.html" class="dropdown-item">Our Team</a>
                  <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                </div>
              </div>
              <a href="edit.php" class="nav-item nav-link">Data Reservasi</a>
            </div>
            <a href="index.php" class="btn btn-primary py-2 px-4">USER FORM</a>
          </div>
        </nav>

        <div class="container-xxl py-5 bg-dark hero-header mb-5">
          <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Admin Accses</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="login.html">Admin Login</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Contact Admin</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <!-- Navbar & Hero End -->
        <!-- Formulir untuk menambah atau mengedit data -->
        <section id="form-section">
    <div class="container-xxl py-5">
        <div class="container">
            <h2 class="text-center mb-4">UPDATE DATA</h2>
            <form method="post" action="">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="subjek" class="form-label">Subjek</label>
                    <input type="text" class="form-control" id="subjek" name="subjek" value="<?php echo $subjek; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea class="form-control" id="pesan" name="pesan" rows="4" required><?php echo $pesan; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            </form>
        </div>
    </div>
</section>

         <!-- untuk mengeluarkan data -->
         <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Contact
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">SUBJEK</th>
                            <th scope="col">PESAN</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from contact order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id       = $r2['id'];
                            $nama     = $r2['nama'];
                            $email    = $r2['email'];
                            $subjek    = $r2['subjek'];
                            $pesan   = $r2['pesan'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $email ?></td>
                                <td scope="row"><?php echo $subjek ?></td>
                                <td scope="row"><?php echo $pesan ?></td>
                                <td scope="row">
                                    <a href="?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
          <div class="row g-5">
            <div class="col-lg-3 col-md-6">
              <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Company</h4>
              <a class="btn btn-link" href="about.html">About Us</a>
              <a class="btn btn-link" href="contact.html">Contact Us</a>
              <a class="btn btn-link" href="#reservasi">Reservation</a>
            </div>
            <div class="col-lg-3 col-md-6">
              <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
              <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Jl. Jendral Sudirman no 20</p>
              <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+62 8575 5552 746</p>
              <p class="mb-2"><i class="fa fa-envelope me-3"></i>youraresto@gmail.com</p>
              <div class="d-flex pt-2">
                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Opening</h4>
              <h5 class="text-light fw-normal">Everyday</h5>
            </div>
            <div class="col-lg-3 col-md-6">
              <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Info</h4>
              <p>Menjamin pengiriman paling lambat 1 jam di daerah karisidenan madiun.</p>
            </div>
          </div>
        </div>
        <div class="container text-center">
          <div class="copyright">
            <div class="row">
              <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <a href="#">@Copyright 2023</a>
                Dibuat Oleh <a href="https://www.instagram.com/youngkireza_/">@youngkireza_</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer End -->
</body>

</html>
