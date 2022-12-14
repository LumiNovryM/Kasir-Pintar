<?php include 'connect.php';
// Get data dari Produk
$get_data_produk = mysqli_query($connect,"SELECT * FROM produk");
$count_data_produk = mysqli_num_rows($get_data_produk); // Menghitung seluruh kolom
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Produk Page</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="dashboard.php">Kasir Pintar</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
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
                    <h1 class="mt-4">Data Produk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard/Produk</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah Produk  <?= $count_data_produk ?></div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Produk
                    </button>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Harga Modal</th>
                                        <th>Harga Jual</th>
                                        <th>Stock</th>
                                        <th>Tgl Input</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>

                                <?php
                                $get = mysqli_query($connect, "SELECT * FROM produk");
                                $i = 1;

                                while($p=mysqli_fetch_array($get)){
                                ?>


                                <tbody>
                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><?=$p['kode_produk'];?></td>
                                        <td><?=$p['nama_produk'];?></td>
                                        <td>Rp.<?=number_format($p['harga_modal']);?></td>
                                        <td>Rp<?=number_format($p['harga_jual']);?></td>
                                        <td><?=$p['stock'];?></td>
                                        <td><?=$p['tgl_input'];?></td>
                                        <td><button type="button" class="btn btn-primary btn-xs mr-1" data-bs-toggle="modal" data-bs-target="#EditProduk<?php echo $p['id_produk']; ?>">
                                                <i class="fas fa-pencil-alt fa-xs mr-1"></i>Edit
                                            </button>
                                            <a class="btn btn-danger btn-xs" href="?hapus=<?php echo $p['id_produk']; ?>">
                                            <i class="fas fa-trash-alt fa-xs mr-1"></i>Hapus</a>
                                        </td>
                                    </tr>



                                    <div class="modal fade" id="EditProduk<?php echo $p['id_produk']; ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content border-0">
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="samll">Kode Produk :</label>
                                                            <input type="hidden" name="id_produk" value="<?php echo $p['id_produk']; ?>">
                                                            <input type="text" name="Edit_Kode_Produk" value="<?php echo $p['kode_produk']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="samll">Nama Produk :</label>
                                                            <input type="text" name="Edit_Nama_Produk" value="<?php echo $p['nama_produk']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="samll">Jumlah Barang :</label>
                                                            <input type="text" name="Edit_Stock_Produk" value="<?php echo $p['stock']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="samll">Harga Modal :</label>
                                                            <input type="number" placeholder="0" name="Edit_Harga_Modal" value="<?php echo $p['harga_modal']; ?>" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="samll">Harga Jual :</label>
                                                            <input type="number" placeholder="0" name="Edit_Harga_Jual" value="<?php echo $p['harga_jual']; ?>" class="form-control" required>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
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
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <form method="post">
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label class="samll">Kode Produk :</label>
                    <input type="text" name="Tambah_Kode_Produk" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="samll">Nama Produk :</label>
                    <input type="text" name="Tambah_Nama_Produk" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="samll">Jumlah Barang :</label>
                    <input type="text" name="Tambah_Stock_Produk" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="samll">Harga Modal :</label>
                    <input type="number" placeholder="0" name="Tambah_Harga_Modal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="samll">Harga Jual :</label>
                    <input type="number" placeholder="0" name="Tambah_Harga_Jual" class="form-control" required>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" name="tambah-produk">Submit</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

</html>