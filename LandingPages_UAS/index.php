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
    <title>YOURA | RESTO AND CAFE</title>
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
              <a href="index.html" class="nav-item nav-link active">Home</a>
              <a href="about.html" class="nav-item nav-link">About</a>
              <a href="menu.html" class="nav-item nav-link">Menu</a>
              <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0">
                  <a href="booking.php" class="dropdown-item">Booking</a>
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
          <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
              <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-3 text-white animated slideInLeft">Nikmati Sajian<br />Lezat dari Kami</h1>
                <p class="text-white animated slideInLeft mb-4 pb-2">
                  Youra Resto and Cafe siap melayani anda sepenuh hati, dengan berbagai sajian makanan dan minuman terbaik di kelasnya karna kami adalah lambang kesmpurnaan rasa. Puasakan lidah dan perut anda
                </p>
                <a href="" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Book A Table</a>
              </div>
              <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                <img class="img-fluid" src="img/hero.png" alt="" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Navbar & Hero End -->

      <!-- Service Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="service-item rounded pt-3">
                <div class="p-4">
                  <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                  <h5>Chef Berpengalaman</h5>
                  <p>Seorang juru masak yang telah banyak berkecimpung di dunia kuliner selama bertahun-tahun.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="service-item rounded pt-3">
                <div class="p-4">
                  <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                  <h5>makanan Berkualitas</h5>
                  <p>Makanan fresh yang diambil langsung dari pertanian dan perkebunan terpercaya dan lulus uji kebersihan.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="service-item rounded pt-3">
                <div class="p-4">
                  <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                  <h5>Online Order</h5>
                  <p>Siap melayani pesanan online dan di dukung oleh beberapa perusahaan pengantar makanan tercepat.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
              <div class="service-item rounded pt-3">
                <div class="p-4">
                  <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                  <h5>Layanan 24/7</h5>
                  <p>Siap melayani anda kapanpun, tak kenal waktu dan cuaca yang terjadi. karna itu adalah dedikasi kami.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Service End -->

      <!-- About Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-5 align-items-center">
            <div class="col-lg-6">
              <div class="row g-3">
                <div class="col-6 text-start">
                  <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="img/about-1.jpg" />
                </div>
                <div class="col-6 text-start">
                  <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s" src="img/about-2.jpg" style="margin-top: 25%" />
                </div>
                <div class="col-6 text-end">
                  <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s" src="img/about-3.jpg" />
                </div>
                <div class="col-6 text-end">
                  <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s" src="img/about-4.jpg" />
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <h5 class="section-title ff-secondary text-start text-primary fw-normal">About Us</h5>
              <h1 class="mb-4">Welcome to <br /><i class="fa fa-utensils text-primary me-2"></i>Youra Resto & Cafe</h1>
              <p class="mb-4">Didirikan pada tahun 2003 oleh Younky Reza di Ponorogo dengan tujuan untuk menaikkan standar rasa yang ada di kotanya saat itu.</p>
              <p class="mb-4">Dan kini sudah diwariskan dari generasi ke generasi dengan proses seleksi chef yang ketat dan pengembangan resep terus menerus, menjamin cita rasa yang mempunyai kenikmatan abadi dan terasa spesial.</p>
              <div class="row g-4 mb-4">
                <div class="col-sm-6">
                  <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">21</h1>
                    <div class="ps-4">
                      <p class="mb-0">Years of</p>
                      <h6 class="text-uppercase mb-0">Experience</h6>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">37</h1>
                    <div class="ps-4">
                      <p class="mb-0">Chef</p>
                      <h6 class="text-uppercase mb-0">ahli Pilihan</h6>
                    </div>
                  </div>
                </div>
              </div>
              <a class="btn btn-primary py-3 px-5 mt-2" href="">Read More</a>
            </div>
          </div>
        </div>
      </div>
      <!-- About End -->

      <!-- Menu Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu Makanan</h5>
            <h1 class="mb-5">Daftar Menu Populer</h1>
          </div>
          <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
            <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
              <li class="nav-item">
                <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                  <i class="fa fa-coffee fa-2x text-primary"></i>
                  <div class="ps-3">
                    <small class="text-body">Menu</small>
                    <h6 class="mt-n1 mb-0">Sarapan</h6>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-2">
                  <i class="fa fa-hamburger fa-2x text-primary"></i>
                  <div class="ps-3">
                    <small class="text-body">Menu</small>
                    <h6 class="mt-n1 mb-0">Makan Siang</h6>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-3">
                  <i class="fa fa-utensils fa-2x text-primary"></i>
                  <div class="ps-3">
                    <small class="text-body">menu</small>
                    <h6 class="mt-n1 mb-0">Makan Malam</h6>
                  </div>
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div id="tab-1" class="tab-pane fade show p-0 active">
                <div class="row g-4">
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="Aset_web/makanan/pagi/nasi_goreng.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Nasi Goreng</span>
                          <span class="text-primary">Rp15.000</span>
                        </h5>
                        <small class="fst-italic"> nasi yang digoreng bersama bumbu-bumbu seperti bawang putih, bawang merah, kecap manis, dan tambahan lainnya.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="Aset_web/makanan/pagi/kopi_cangkir.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Kopi cangir</span>
                          <span class="text-primary">Rp35.000</span>
                        </h5>
                        <small class="fst-italic">Ada berbagai jenis kopi, seperti kopi tubruk, kopi susu, kopi hitam, dan lain-lain.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="Aset_web/makanan/pagi/bubur_ayam.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Bubur Ayam</span>
                          <span class="text-primary">Rp20.000</span>
                        </h5>
                        <small class="fst-italic"> bubur nasi yang dimasak dengan kaldu ayam dan disajikan dengan potongan daging ayam, bawang goreng, seledri, dan kecap.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/pagi/rujak_petis.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Rujak Petis</span>
                          <span class="text-primary">Rp20.000</span>
                        </h5>
                        <small class="fst-italic"> hidangan rujak yang memasukkan sayuran segar sebagai bahan utama, ditambah dengan sambal petis yang khas.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/pagi/susu_jahe.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Susu Jahe</span>
                          <span class="text-primary">Rp12.000</span>
                        </h5>
                        <small class="fst-italic">minuman hangat yang terbuat dari campuran susu dengan jahe yang diparut.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/pagi/lontong_sayur.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Lontong Sayur</span>
                          <span class="text-primary">Rp17.000</span>
                        </h5>
                        <small class="fst-italic">hidangan berupa lontong (ketupat), sayuran seperti kacang panjang, tahu, dan tempe yang dimasak dalam kuah santan yang gurih.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="Aset_web/makanan/pagi/jus_buah.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Jus Buah</span>
                          <span class="text-primary">Rp22.000</span>
                        </h5>
                        <small class="fst-italic"> Jus buah segar seperti jus jeruk, jus mangga, atau jus lainnya</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="Aset_web/makanan/pagi/teh_tarik.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Teh tarik</span>
                          <span class="text-primary">Rp19.000</span>
                        </h5>
                        <small class="fst-italic"> teh hitam yang ditarik-tarik sehingga menghasilkan buih di permukaan teh.</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- MAKAN SIANG -->
              <div id="tab-2" class="tab-pane fade show p-0">
                <div class="row g-4">
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/wagyu_panggang.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Wagyu Pangang</span>
                          <span class="text-primary">Rp800.000</span>
                        </h5>
                        <small class="fst-italic"> Potongan daging wagyu yang dipanggang sempurna, disajikan dengan saus truffle yang kaya dan lezat.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/udang_sambal_mattah.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Udang Sambal Matah</span>
                          <span class="text-primary">Rp650.000</span>
                        </h5>
                        <small class="fst-italic">Udang lokal segar dengan sambal matah yang disajikan dengan sentuhan modern dan presentasi yang menarik.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/sub_lobster.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Sup Lobster</span>
                          <span class="text-primary">Rp500.000</span>
                        </h5>
                        <small class="fst-italic">Sup lobster mewah dengan tambahan bakso laut untuk menciptakan kombinasi rasa yang istimewa.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/eskrim_kentan.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Es Krim Kentan hitam</span>
                          <span class="text-primary">Rp40.000</span>
                        </h5>
                        <small class="fst-italic"> Es krim ketan hitam cokelat yang lezat disajikan dengan sambal lengkeng yang memberikan sentuhan lokal yang mengejutkan.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/pudding_pandan.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Puding pandan</span>
                          <span class="text-primary">Rp25.000</span>
                        </h5>
                        <small class="fst-italic">Puding pandan yang lembut dengan siraman karamel kelapa untuk memberikan cita rasa tradisional.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/cocktail_sirsak.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Cocktail Sirsak Jeruk</span>
                          <span class="text-primary">Rp35.000</span>
                        </h5>
                        <small class="fst-italic"> Minuman segar dengan campuran sirsak dan jeruk Bali untuk sentuhan tropis yang eksotis.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/mocktail_leci_melati.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Mocktail Leci Melati</span>
                          <span class="text-primary">Rp35.000</span>
                        </h5>
                        <small class="fst-italic"> Minuman tanpa alkohol dengan kombinasi leci segar dan sirup melati untuk cita rasa yang ringan.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/siang/bakso_raksasa.jpeg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Bakso Raksasa</span>
                          <span class="text-primary">Rp350.000</span>
                        </h5>
                        <small class="fst-italic">Bakso berukuran raksasa dengan taburan sambal di atasnya dan dengan isi bakso kecil di dalamnya.</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- MAKAN MALAM -->
              <div id="tab-3" class="tab-pane fade show p-0">
                <div class="row g-4">
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/sub_jamur.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Sup Jamur</span>
                          <span class="text-primary">Rp25.000</span>
                        </h5>
                        <small class="fst-italic">Sup jamur yang lezat dengan sentuhan truffle oil untuk aroma mewah.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/klepon_modern.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Klepon Modern</span>
                          <span class="text-primary">Rp30.000</span>
                        </h5>
                        <small class="fst-italic"> Klepon dengan sentuhan modern, diisi dengan cokelat leleh dan disajikan dengan es krim kelapa.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/lobster_bakar.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Lobster Bakar</span>
                          <span class="text-primary">Rp450.000</span>
                        </h5>
                        <small class="fst-italic"> Lobster segar yang dipanggang dan disajikan dengan saus asam manis yang menggoda selera.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/soto_betawi.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Soto Betawi royale</span>
                          <span class="text-primary">Rp25.000</span>
                        </h5>
                        <small class="fst-italic">Soto Betawi dengan tambahan daging sapi empuk, telur pindang, dan kentang goreng sebagai variasi yang istimewa.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/nasi_goreng_seafood.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Nasi Goreng Seafood</span>
                          <span class="text-primary">Rp40.000</span>
                        </h5>
                        <small class="fst-italic"> Nasi goreng yang lezat dengan campuran seafood, sayuran, dan telur mata sapi di atasnya.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/puding_mangga.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Puding Mangga</span>
                          <span class="text-primary">Rp35.000</span>
                        </h5>
                        <small class="fst-italic"> Puding mangga yang segar disajikan dengan srikaya caramel untuk sentuhan manis.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/capcai_special.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Capcay Special</span>
                          <span class="text-primary">Rp35.000</span>
                        </h5>
                        <small class="fst-italic"> Capcay dengan campuran sayuran segar dan seafood dalam saus yang lezat.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="d-flex align-items-center">
                      <img class="flex-shrink-0 img-fluid rounded" src="aset_web/makanan/malam/cocktail_anggur.jpg" alt="" style="width: 80px" />
                      <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                          <span>Cocktail anggur</span>
                          <span class="text-primary">Rp45.000</span>
                        </h5>
                        <small class="fst-italic">Campuran anggur hijau yang elegan dengan sirup sirsak untuk rasa yang menyegarkan.</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Menu End -->

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
            <div class="modal-body">
              <!-- 16:9 aspect ratio -->
              <div class="ratio ratio-16x9">
                <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Reservation Start -->

      <!-- Team Start -->
      <div class="container-xxl pt-5 pb-3">
        <div class="container">
          <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Leaderboard</h5>
            <h1 class="mb-5">Chef Terbaik Kami</h1>
          </div>
          <div class="row g-4">
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="team-item text-center rounded overflow-hidden">
                <div class="rounded-circle overflow-hidden m-4">
                  <img class="img-fluid" src="aset_web/orang/chef/itsme1.jpg" alt="" />
                </div>
                <h5 class="mb-0">Younky Reza</h5>
                <small>Executive Chef</small>
                <div class="d-flex justify-content-center mt-3">
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="team-item text-center rounded overflow-hidden">
                <div class="rounded-circle overflow-hidden m-4">
                  <img class="img-fluid" src="aset_web/orang/chef/bimbim.jpeg" alt="" />
                </div>
                <h5 class="mb-0">Bimbim Drunk</h5>
                <small>Sous Chef</small>
                <div class="d-flex justify-content-center mt-3">
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="team-item text-center rounded overflow-hidden">
                <div class="rounded-circle overflow-hidden m-4">
                  <img class="img-fluid" src="aset_web/orang/chef/bryan2.jpeg" alt="" />
                </div>
                <h5 class="mb-0">Bryan O'corner</h5>
                <small>Personal Chef</small>
                <div class="d-flex justify-content-center mt-3">
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
              <div class="team-item text-center rounded overflow-hidden">
                <div class="rounded-circle overflow-hidden m-4">
                  <img class="img-fluid" src="aset_web/orang/chef/gendut.jpeg" alt="" />
                </div>
                <h5 class="mb-0">Chef Gendut</h5>
                <small>Catering chef</small>
                <div class="d-flex justify-content-center mt-3">
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                  <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Team End -->

      <!-- Testimonial Start -->
      <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
          <div class="text-center">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Testimonial</h5>
            <h1 class="mb-5">Komentar Pelangan kami</h1>
          </div>
          <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item bg-transparent border rounded p-4">
              <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
              <p>Sangat puas dengan rasa sub jamur dan puding mangganya.</p>
              <div class="d-flex align-items-center">
                <img class="img-fluid flex-shrink-0 rounded-circle" src="aset_web/orang/public/bimo.jpeg" style="width: 50px; height: 50px" />
                <div class="ps-3">
                  <h5 class="mb-1">Omib Pamungkas</h5>
                  <small>Pengusaha</small>
                </div>
              </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded p-4">
              <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
              <p>Tempatnya sangat bagus dan rasa makanannya juga sangat enak. Rekomended banget</p>
              <div class="d-flex align-items-center">
                <img class="img-fluid flex-shrink-0 rounded-circle" src="aset_web/orang/public/bryan.jpeg" style="width: 50px; height: 50px" />
                <div class="ps-3">
                  <h5 class="mb-1">Bryan Adams</h5>
                  <small>Penyanyi</small>
                </div>
              </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded p-4">
              <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
              <p>Rekomendasi untuk orang yang suka makanan lokal tetapi rasa internasional.</p>
              <div class="d-flex align-items-center">
                <img class="img-fluid flex-shrink-0 rounded-circle" src="aset_web/orang/public/wildan2.jpeg" style="width: 50px; height: 50px" />
                <div class="ps-3">
                  <h5 class="mb-1">Sir Wildans</h5>
                  <small>Pembalap Nasional</small>
                </div>
              </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded p-4">
              <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
              <p>Pelayanannya sangat bagus, makanannya super enak, tempatnya bagus dan nyaman, rekomendasi buat milenial.</p>
              <div class="d-flex align-items-center">
                <img class="img-fluid flex-shrink-0 rounded-circle" src="aset_web/orang/public/gendut.jpeg" style="width: 50px; height: 50px" />
                <div class="ps-3">
                  <h5 class="mb-1">Gendut Mukbang</h5>
                  <small>Food Vloger</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Testimonial End -->

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
