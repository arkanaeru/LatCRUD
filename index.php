<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "latihan1";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tnamaak bisa terkoneksi ke database");
}
$nama       = "";
$npm        = "";
$prodi      = "";
$no_telp    = "";
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $nama         = $_GET['nama'];
    $sql1       = "delete from mhs where nama = '$nama'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $nama         = $_GET['nama'];
    $sql1       = "select * from mhs where nama = '$nama'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nama       = $r1['nama'];
    $npm        = $r1['npm'];
    $prodi      = $r1['prodi'];
    $no_telp    = $r1['no_telp'];

    if ($npm == '') {
        $error = "Data tnamaak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nama       = $_POST['nama'];
    $npm        = $_POST['npm'];
    $prodi      = $_POST['prodi'];
    $no_telp    = $_POST['no_telp'];

    if ($nama && $npm && $prodi && $no_telp) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update mhs set nama='$nama', npm = '$npm',prodi = '$prodi',no_telp='$no_telp' where nama = '$nama'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into mhs(nama, npm, prodi,no_telp) values ('$nama','$npm','$prodi','$no_telp')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="wnamath=device-wnamath, initial-scale=1.0">
    <title>Data mhs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            wnamath: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                LATIHAN CRUD TABEL MAHASISWA
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="npm" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" nama="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nomor Pokok Mahasiswa</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" nama="npm" name="npm" value="<?php echo $npm ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="prodi" class="col-sm-2 col-form-label">Program Studi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" nama="prodi" name="prodi" value="<?php echo $prodi ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" nama="no_telp" name="no_telp" value="<?php echo $no_telp ?>">
                        </div>
                    </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data mhs
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nomor Pokok Mahasiswa</th>
                            <th scope="col">Program Studi</th>
                            <th scope="col">Nomor Telepon</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from mhs order by nama desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $nama         = $r2['nama'];
                            $nama        = $r2['nama'];
                            $npm       = $r2['npm'];
                            $prodi     = $r2['prodi'];
                            $no_telp   = $r2['no_telp'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $npm ?></td>
                                <td scope="row"><?php echo $prodi ?></td>
                                <td scope="row"><?php echo $no_telp ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&nama=<?php echo $nama ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&nama=<?php echo $nama?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
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
</body>

</html>