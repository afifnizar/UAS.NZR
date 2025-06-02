<?php
include 'koneksi.php';

// Ambil data dari database
$query = "SELECT * FROM kegiatan";
$result = mysqli_query($koneksi, $query);

$no = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- nav start -->
    <header>
        <h1 class="logo"><span>mafif</span>nizar</h1>
        <nav>
            <a href="#beranda">Beranda</a>
            <a href="#about">Tentang saya</a>
            <a href="#portofolio">Portofolio</a>
            <a href="#Opini">Opini</a>
        </nav>
    </header>

    <!-- beranda section -->
     <section class="beranda" id="beranda"> 
        <div class="poto">
          <img src="poto.jpg" alt="">
        </div>
        <main class="judul">         
          <h1>Hello,my <span>Name is</span></h1>
          <h2>MUHAMMAD AFIF NIZAR NUR ROHMAN</h2>
            <div class="button">
              <a href="#contact">selengkapnya</a>
            </div>
            </main>
     </section>

     <!-- about section -->
      <section class="about" id="about">
        <h1>Tentang <span>Saya</span></h1>
        <div class="kami">
          <p>Nama saya Muhammad Afif Nizar Nur Rohman, mahasiswa aktif Program Studi Teknik Informatika di Universitas Nahdlatul Ulama Sunan Giri, saat ini berada di semester 2 (Dua). Saya memiliki minat besar dalam pengembangan perangkat lunak, kecerdasan buatan, dan keamanan siber. Selama kuliah, saya aktif mengikuti organisasi kemahasiswaan dan berbagai proyek teknologi untuk mengasah kemampuan praktis di bidang pemrograman, pengelolaan basis data, dan pengembangan aplikasi. Saya juga berusaha mempertahankan prestasi akademik dengan terus belajar dan mengikuti berbagai pelatihan tambahan seperti coding bootcamp dan seminar teknologi. Dengan bekal pengetahuan dan keterampilan ini, saya bertekad untuk berkontribusi dalam dunia industri teknologi serta terus mengembangkan inovasi yang bermanfaat bagi masyarakat</p>
          <img src="poto.2.jpg" alt="" width="350px">
        </div>
      </section>
    
      <!--portofolio  -->
          <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: black; }
        tr:nth-child(even) { background-color: black; }
        .btn { padding: 5px 10px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-danger { background-color: #f44336; color: white; border: none; }
        .btn-danger:hover { background-color: #d32f2f; }
        .btn-primary { background-color: #4CAF50; color: white; border: none; margin: 1px; }
        .btn-primary:hover { background-color: #45a049; }
        .form-group { margin-bottom: 15px; }
        .form-control { width: 100%; padding: 8px; box-sizing: border-box; }
    </style>
      <section class="portofolio" id="portofolio">

      </section>
        <h2>Data <span> Kegiatan</span></h2>
        <!-- Form Tambah Data -->
        <div class="header-actions">
            <a href="tambah.php" class="btn btn-success">+ Tambah Data Baru</a>
            <div class="data-count">
                Total data: <?php echo mysqli_num_rows($result); ?> kegiatan
            </div>
        </div>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <!-- <th width="10%">No</th> -->
                    <th width="15%">No</th>
                    <th width="35%">Nama Kegiatan</th>
                    <th width="25%">Waktu Kegiatan</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <!-- <td><?php echo $no++; ?></td> -->
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_kgt']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['waktu_kgt'])); ?></td>
                    <td class="action-buttons">
                        <a href="edit.php?id=<?php echo urlencode($row['id']); ?>" 
                           class="btn btn-warning"
                           title="Edit data">
                            ✏ Edit
                        </a>
                        <a href="hapus.php?id=<?php echo urlencode($row['id']); ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('⚠ Apakah Anda yakin ingin menghapus data kegiatan:\n\n<?php echo addslashes($row['nama_kgt']); ?>?\n\nData yang dihapus tidak dapat dikembalikan!')"
                           title="Hapus data">
                            🗑 Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-data">
            <h3>Belum ada data kegiatan</h3>
            <p>Silakan tambah data kegiatan baru dengan mengklik tombol "Tambah Data Baru" di atas.</p>
        </div>
        <?php endif; ?>
    </div>


    <!-- opini -->
     
       <section class="Opini" id="Opini">
          <h1>Opini</h1>
            <div class="grid-container">
              <div class="card">
                <video autoplay loop muted><source src="higtligt.1.mp4"></video>
                <div class="judul-overlay">Goal pembuka dari M. Thuram (inter milan) di detik 33 </div>
              </div>
              <div class="card">
                <video autoplay loop muted><source src="higtligt.2.mp4"></video>
                <div class="judul-overlay">Goal fantastis dari D.Dumfries (inter milan) di menit 21</div>
              </div>
              <div class="card">
                <video autoplay loop muted><source src="higtligt.3.mp4"></video>
                <div class="judul-overlay">Goal memukau dari lamine yamal (Barcelona) di menit 24 </div>
              </div>
              <div class="card">
                <video autoplay loop muted><source src="higtligt.4.mp4"></video>
                <div class="judul-overlay">Ferran Tores berhasil mencetak goal di menit 38 dan Barca unggul 1 point </div>
              </div>
              <div class="card">
                <video autoplay loop muted><source src="higtligt.5.mp4"></video>
                <div class="judul-overlay">inter tidak mau kalah, D.Dumfries mencetak gol keduanya di menit 63</div>
              </div>
              <div class="card">
                <video autoplay loop muted><source src="higtligt.6.mp4"></video>
                <div class="judul-overlay">Tendangan dari luar kotak penalti dari raphinha membuahkan goal penentu di menit 65 </div>
              </div>
            </div>
        </section>
         <main class="panggil" id="contact">
          <section class="section contact">
            <div class="conttainer">
              <div class="section-title">
                <h2>Contact</h2>
              </div>
              <div class="contact-content">
                <div class="contact-info">
                  <h3>Hubungi Kami</h3>
                  <p>
                    Jangan ragu untuk menghubungi kami jika Anda mencari pengembang,
                    memiliki pertanyaan, atau hanya ingin terhubung.
                  </p>
      
                  <div class="contact-details">
                    <div class="contact-item">
                      <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                      </div>
                      <div>
                        <h4>Phone</h4>
                        <p>+62857-5755-2454</p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="contact-item">
                    <div class="contact-icon">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                      <h4>Email</h4>
                      <p>nizariwii653@gmail.com</p>
                    </div>
                  </div>
                  
                  <div class="contact-item">
                    <div class="contact-icon">
                      <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                      <h4>Location</h4>
                      <p>Bojonegoro, Jawa Timur, Indonesia</p>
                    </div>
                  </div>
                  
                  <div class="maps">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.102681289074!2d111.96932967357061!3d-7.229127970989519!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78293df72c57db%3A0xada75e55d7c51bab!2sBengkel%20Las%20Karbit%20dan%20Listrik!5e0!3m2!1sid!2sid!4v1746256024488!5m2!1sid!2sid" width="480" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                </div>
      
                <div class="contact-form">
                  <form>
                    <div class="form-group">
                      <label for="name">Nama Kamu</label>
                      <input type="text" id="name" class="form-control" required />
                    </div>
      
                    <div class="form-group">
                      <label for="email">Email kamu</label>
                      <input type="email" id="email" class="form-control" required />
                    </div>
      
                    <div class="form-group">
                      <label for="subject">Subject</label>
                      <input type="text" id="subject" class="form-control" required />
                    </div>
      
                    <div class="form-group">
                      <label for="message">Pesan </label>
                      <textarea id="message" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Kirim Pesan</button>
                  </form>
                </div>
              </div>
            </div>
          </section>
         </main>

         <footer>
          &copy;Copyright By:Nizarshter
         </footer>
            <script>
        // Auto hide alert messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>