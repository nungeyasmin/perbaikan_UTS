<?php
//koneksi database
$server = "localhost";
$user = "root";
$pass = "";
$database = "londryp2s2";

$koneksi = mysqli_connect($server, $user, $pass, $database)or die (mysqli_error($koneksi));

//jika tombol simpan diklik
if(isset($_POST['bsimpan']))
{
    //pengujian apakah data akan diedit / disimpan baru
    if($_GET['hal'] == "edit")
    {
        //data akan diedit
        $edit = mysqli_query($koneksi, " UPDATE tsantri set 
                                        nis = '$_POST[tnis]';
                                        nama = '$_POST[tnama]';
                                        asrama = '$_POST[tasrama]';
                                        WHERE id_santri = '$_GET[id]' ");
if($edit) //jika edit sukses
{
    echo "<script>
    alert('Edit data sukses');
    document.location='index.php';
    </script>";
}else{
    echo "<script>
    alert('Edit data gagal');
    document.location='index.php';
    </script>";
}
    }else{
        //data akan disimpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO tsantri (nis,nama,asrama)
                                            VALUE ('$_POST[tnis]',
                                            '$_POST[tnama]',
                                            '$_POST[tasrama]'");
                                           
        
if($simpan) //jika simpan sukses
    {
        echo "<script>
        alert('Simpan data sukses');
        document.location='index.php';
        </script>";
    }else{
        echo "<script>
        alert('Simpan data gagal');
        document.location='index.php';
        </script>";
        }
    }   
}
//pengujian jika tombol hapus / edit diklik
if(isset($_GET['hal']))
{
    //pengujian jika edit data
    if($_GET['hal'] == "edit")
    {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tsantri WHERE id_santri = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            //jika data ditemukan, maka data ditampung ke dalam variabel
            $vnis =$data['nis'];
            $vnama =$data['nama'];
            $vasrama =$data['asrama'];
        }
    }elseif ($_GET['hal'] == "hapus")
    {
        //persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tsantri WHERE id_santri = '$_GET[id]' ");
        if($hapus){
            echo "<script>
            alert('Hapus data sukses');
            document.location='index.php';
            </script>";
        }
        
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>LONDRYP2S2</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-3">

        <h1 class="text-center">LONDRY P2S2</h1>
        <h2 class="text-center">2023-2024</h2>
        <!-- Awal Card Form -->
        <div class="card mt-3 bg-warning">
            <div class="card-header bg-info">
                Form Input Data Santri
            </div>
            <div class="card-body">
                <form menthod="post" action="">
                    <div class="form-grop">
                        <label>NIS</label>
                        <input type="text" name="tnis" value="<?=@$vnis?>" class="form-control"
                            placeholder="input NIS anda disini" required>
                    </div>
                    <div class="form-grop">
                        <label>Nama</label>
                        <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control"
                            placeholder="input Nama anda disini" required>
                    </div>
                    <div class="form-grop">
                        <label>asrama</label>
                        <select class="form-control" name="tasrama">
                            <option value="<?=@$vkamar?>"><?=@$vkamar?></option>
                            <option value="NY nursari">"NY nursari"</option>
                            <option value="NY zubaida">"NY zubaida"</option>
                            <option value="NY saidah">"NY saidah"</option>
                            <option value="NY mukorramah">"NY mukorramah"</option>
                            <option value="NY saidah">"NY saidah"</option>
                            <option value="NY zainiyah">"NY zainiyah"</option>
                            <option value="imrotutaksis">"imrotutaksis"</option>

                        </select>
                    </div>
                </form>
                <button type="submit" class="btn btn-success mt-3" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger mt-3" name="breset">Kosongkan</button>
            </div>
        </div>
        <!-- Akhir Card Form -->

        <!-- Awal Card Tabel -->
        <div class="card mt-3 bg-info">
            <div class="card-header bg-warning">
                Daftar Santri Yang melakukan londri pakaian
            </div>
            <div class="card-body">
                <table class="table table-bordered table-info">
                    <tr>
                        <th>NO</th>
                        <th>NIS</th>
                        <th>NAMA</th>
                        <th>ASRAMA</th>
                        <th>act</th>
                    </tr>
                    <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from t_santri order by id_santri desc");
            while($data = mysqli_fetch_array($tampil)):n
            ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$data['nis']?></td>
                        <td><?=$data['nama']?></td>
                        <td><?=$data['asrama']?></td>
                        <td>
                            <a href="index.php?hal=edit&id=<?=$data['id_santri']?>" class="btn btn-dark">Edit</a>
                            <a href="index.php?hal=hapus&id=<?=$data['id_santri']?>"
                                onclick="return confirm ('Apakah anda yakin ingin menghapus data ini?')"
                                class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; //penutup perulangan while ?>
                </table>

            </div>
        </div>
        <!-- Akhir Card Tabel-->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
</body>
</body>

</html>