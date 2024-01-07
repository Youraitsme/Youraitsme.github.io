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
$waktu     = "";
$jumlah   = "";
$permintaan   = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from reservasi where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from reservasi where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama        = $r1['nama'];
    $email       = $r1['email'];
    $waktu     = $r1['waktu'];
    $jumlah   = $r1['jumlah'];
    $permintaan   = $r1['permintaan'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { // Untuk create atau update
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $waktu = $_POST['waktu'];
  $jumlah = $_POST['jumlah'];
  $permintaan = $_POST['permintaan'];

  if ($nama && $email && $waktu && $jumlah && $permintaan) {
      if ($op == 'edit') { // Untuk update
          $sql1 = "update reservasi set nama = '$nama', email='$email', waktu = '$waktu', jumlah='$jumlah', permintaan='$permintaan' where id = '$id'";
          $q1 = mysqli_query($koneksi, $sql1);
          if ($q1) {
              $sukses = "Data berhasil diupdate";
          } else {
              $error = "Data gagal diupdate";
          }
      } else { // Untuk insert
          $sql1 = "insert into reservasi(nama, email, waktu, jumlah, permintaan) values ('$nama', '$email', '$waktu', '$jumlah', '$permintaan')";
          $q1 = mysqli_query($koneksi, $sql1);
          if ($q1) {
              $sukses = "Berhasil memasukkan data baru";
              // Mengosongkan kolom formulir setelah pengiriman berhasil
              $nama = "";
              $email = "";
              $waktu = "";
              $jumlah = "";
              $permintaan = "";
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
    <meta charset="utf-8" />
    <title>BOOKING | YOURA RESTO AND CAFE</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

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

  <body>
    <div class="container-xxl bg-white p-0">
      <!-- Spinner Start -->
      <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      <!-- Spinner End -->

      <!-- Navbar & Hero Start -->
      <div class="container-xxl position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
          <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Youra Resto & Cafe</h1>
            <!-- <img src="img/logo.png" alt="Logo"> -->
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
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0">
                  <a href="booking.php" class="dropdown-item active">Booking</a>
                  <a href="team.html" class="dropdown-item">Our Team</a>
                  <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                </div>
              </div>
              <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
            <a href="login.html" class="btn btn-primary py-2 px-4">Admin Login</a>
          </div>
        </nav>

        <div class="container-xxl py-5 bg-dark hero-header mb-5">
          <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Booking</h1>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Booking</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
      <!-- Navbar & Hero End -->

      <!-- Reservation Start -->
      <section id="reservasi">
        <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
          <div class="row g-0">
            <div class="col-md-6">
              <div class="video">
                <span></span>
              </div>
            </div>
            <div class="col-md-6 bg-dark d-flex align-items-center">
              <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reservation</h5>
                <h1 class="text-white mb-4">Book A Table Online</h1>
                <form action="" method="POST">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>" />
                        <label for="nama">Your Name</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>" />
                        <label for="email">Your Email</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="waktu" name="waktu" value="<?php echo $waktu ?>"/>
                        <label for="waktu">Date And Time</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah ?>"/>
                        <label for="jumlah">Number Of People</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating">
                        <textarea class="form-control" name="permintaan" id="permintaan" value="<?php echo $permintaan ?>" style="height: 100px"></textarea>
                        <label for="permintaan">Special Request</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100 py-3" type="submit" name="simpan" value="simpan data">Book Now</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content rounded-0">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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

      <!-- Back to Top -->
      <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
  </body>
</html>
