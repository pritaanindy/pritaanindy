<?php
    //Koneksi Database
    $server = "localhost";
    $user ="root";
    $pass ="";
    $database ="dblatihan";
    
    $Koneksi = mysqli_Connect($server, $user, $pass, $database)or die(mysqli_error($Koneksi));

    //jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //Pengujian Apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
           // Data akan di edit
          $edit = mysqli_query($Koneksi,"UPDATE tmhs set
                                          nim = '$_POST[tnim]',
                                          nama = '$_POST[tnama]',
                                          alamat = '$_POST[talamat]',
                                          program = '$_POST[program]'
                                         WHERE id_mhs = '$_GET[id]'
                                      ");
            if($edit) //jika edit sukses
            {
                echo "<script>
                    alert('Edit data suksess!');
                    document.location='index.php';
                  </script>";
        }
        else
        {
            echo "<script>
                    alert('Edit data GAGAL!!');
                    document.location='index.php';
                  </script>";
           }
        }
        else
        {   
          //Data akan disimpan Baru
          $simpan = mysqli_query($Koneksi, "INSERT INTO tmhs(nim, nama, alamat, program)
                                         VALUES ('$_POST[tnim]',
                                                '$_POST[tnama]',
                                                '$_POST[talamat]',
                                                '$_POST[tprogram]',
                                         ");
           if($simpan) //jika simpan sukses
        {
            echo "<script>
                    alert('Simpan data suksess!');
                    document.location='index.php';
                  </script>";
        }
        else
        {

            echo "<script>
                    alert('Simpan data GAGAL!!');
                    document.location='index.php';
                  </script>";
        }
        }
        
       
    }
  

//Pengujian jika tombol Edit / Hapus di klik
if(isset($_GET['hal']))
{
    //Pengujian jika edit Data
    if($_GET['hal'] == "edit")
    {
        //Tampilkan Data yang akan diedit
        $tampil = mysqli_query($Koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            //Jika data ditemukan, maka data ditampung ke dalam variabel
            $vnim = $data['nim'];
            $vnama = $data['nama'];
            $valamat = $data['alamat'];
            $vprogram = $data['program'];
          }
        }
        else if ($_GET['hal'] == "hapus")
        {
            //Persiapan hapus data
           $hapus = mysqli_query($Koneksi,"DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
           if($hapus){
              echo "<script>
                      alert('Hapus Data Suksess!!');
                      document.location='index.php';
                    </script>";
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP & MYSQL</title>
    <link rel="stylesheet" type="text/css" href="css/boostrap.min.css">
</head>
<body>
<div class="container">

   <h1 class="text-center">SMK NEGERI 4 BEKASI</h1>
   <h2 class="text-center">SEKOLAH MENENGAH KEJURUSAN</h2>

   <!-- Awal Card Form -->
   <div class="card mt-3">
     <div class="card-header-bg-primary text-white ">
       From Input Data Siswa
     </div>
     <div class="card-body">
       <from method="post" action="">
           <div class="from-group">
              <label>Nim</label>
              <input type="text" name="tnim" value="<?=@$vnim?>" class="from-control" placeholder="Input Nim anda disini!" required >
           </div>
           <div class="from-group">
              <label>Nama</label>
              <input type="text" name="tnama" value="<?=@$vnama?>" class= "from-control"placeholder="Input Nama anda disini!" required>
           </div>
           <div class="from-group">
              <label>Alamat</label>
              <textarea class="form-control" name="talamat" placeholder="Input Alamat anda disini!"><?=@$valamat?></textarea>
           </div>
           <div class="from-group">
              <label>Program jurusan</label>
              <select class="from-control" name="tprogram">
                  <option value="<?=@$vprogram?>"><?=@$vprogram?></option>
                  <option value="Rpl">Rpl</option>
                  <option value="Akuntasi">Akuntasi</option>
                  <option value="Tbsm">Tbsm</option>
                  <option value="Tkj">Tkj</option>
                </select>
           </div>
        
           <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
           <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
        </form>
      </div>
    </div>
    <!-- Akhir Card Form -->


<!-- Awal Card Tabel -->
<div class="card mt-3">
     <div class="card-header-bg-success text-white ">
       Daftar Siswa
     </div>
     <div class="card-body">

       <table class="table table-bordered table-striped">
           <tr>
              <th>No.</th>
              <th>Nim</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Program Kejurusan</th>   
              <th>Aksi</th>
          </tr>
          <?php
              $no = 1;
              $tampil = mysqli_query($Koneksi, "SELECT * from tmhs order by id_mhs desc");
              while($data = mysqli_fetch_array($tampil)) :

            ?>
            <tr>
               <td><?=$no++;?></td>
               <td><?=$data['nim']?></td>
               <td><?=$data['nama']?></td>
               <td><?=$data['alamat']?></td>
               <td><?=$data['program']?></td>
               <td>
                  <a href="index.php?ha1=edit$id=<?=$data['id_mhs']?>"class="btn btn-warning"> Edit </a>
                  <a href="index.php?hal=hapus$id=<?=$data['id_mhs']?>"
                     onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="
                     btn btn-danger"> Hapus </a>
                </td>
            </tr>
        <?php endwhile; //penutup perulangan while ?>
        </table>

      </div>
    </div>
             <td>1</td>
             <td>15.50.002</td>
             <td>Muhammad Saputra</td>
             <td>Tanjung Selor, Kalimantan Utara</td>
             <td>TKJ</td>
         </tr>
     </table>
        
   </div>
 </div>
  <!-- Akhir Card Tabel -->

</div>

<script type="text/javascript" src="js/boostrap.min.js"></script>
</body>
</html>