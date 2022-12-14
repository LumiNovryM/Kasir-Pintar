<?php
    include 'connect.php';

    if(isset($_GET['idpelanggan'])){
        $idpelanggan = $_GET['idpelanggan'];

        $ambilnamapelanggan = mysqli_query($connect,"select * from pesanan p,  pelanggan2 pl where p.idpelanggan and p.idorder=$idpelanggan");
        $np = mysqli_fetch_array ($ambilnamapelanggan);
        $namapel = $np['namapelanggan'];
    }else{
        header('location: order.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Order Page</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">Kasir Pintar</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="login.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="order.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Transaksi
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Produk
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Transaksi: <?=$idpelanggan;?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat Datang</li>
                        </ol>
                        
                        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Barang
                        </button>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Sub-Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $get = mysqli_query($connect,"select * from detailpesanan p, produk pr where p.idproduk=pr.id_produk");
                                    $i = 1;

                                    while($p=mysqli_fetch_array($get)){
                                    $qty = $p['qty'];
                                    $harga = $p['harga_jual'];
                                    $namaproduk = $p['nama_produk'];
                                    $subtotal = $qty*$harga;
                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?></td>
                                            <td>Rp.<?=number_format($harga);?></td>
                                            <td><?=number_format($qty);?></td>
                                            <td>Rp.<?=number_format($subtotal);?></td>
                                            <td>
                                            <button type="button" class="btn btn-primary btn-xs mr-1" data-bs-toggle="modal" data-bs-target="#EditProduk<?php echo $p['id_produk']; ?>">
                                                <i class="fas fa-pencil-alt fa-xs mr-1"></i>Edit
                                            </button>
                                            <a class="btn btn-danger btn-xs" href="?hapus-barang=<?php echo $p['id_produk']; ?>">
                                            <i class="fas fa-trash-alt fa-xs mr-1"></i>Hapus</a>
                                            </td>

                                        </tr>

                                        <div class="modal fade" id="EditView<?php echo $p['id_produk']; ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content border-0">
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="samll">Nama Barang :</label>
                                                            <input type="hidden" name="id_produk" value="<?php echo $p['id_produk']; ?>">
                                                            <input type="text" name="Edit_Nama_View" value="<?php echo $p['id_produk']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="samll">Jumlah :</label>
                                                            <input type="text" name="Edit_Stock_View" value="<?php echo $p['stock']; ?>" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="SimpanEdit">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    };
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <form method="post">
            <!-- Modal body -->
            <div class="modal-body">
            Pilih Barang
                <select name="idproduk" class="form-control">
                    <?php
                    $getproduk = mysqli_query($connect,"select * from produk");
                    
                    while($pl=mysqli_fetch_array($getproduk)){
                        $nama_produk = $pl['nama_produk'];
                        $stock = $pl['stock'];
                        $harga_jual = $pl['harga_jual'];                
                        $id_produk = $pl['id_produk'];                   
                    ?>

                    <option value="<?=$id_produk;?>"><?=$nama_produk;?> - <?=$stock;?></option>

                    <?php
                    }
                    ?>
                </select>

                <input type="number" name="qty" class="from-control mt-4" placeholder="Jumlah">
                <input type="hidden" name="idpesanan" value="<?=$idpesanan;?>">
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="addproduk">Submit</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
</html>
