 <?php include("koneksi.php");
 @session_start();
 ?>
 <!-- === BEGIN HEADER === -->
 <!DOCTYPE html>
 <!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
 <!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
 <!--[if !IE]><!-->
 <html lang="en">
     <!--<![endif]-->
     <head>
         <!-- Title -->
         <title>Amelia Roti </title>
         <!-- Meta -->
         <meta http-equiv="content-type" content="text/html; charset=utf-8" />
         <meta name="description" content="">
         <meta name="author" content="">
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
         <!-- Favicon -->
         <link href="favicon.ico" rel="shortcut icon">
         <!-- Bootstrap Core CSS -->
         <link rel="stylesheet" href="assets/css/bootstrap.css" rel="stylesheet">
         <!-- Template CSS -->
         <link rel="stylesheet" href="assets/css/animate.css" rel="stylesheet">
         <link rel="stylesheet" href="assets/css/font-awesome.css" rel="stylesheet">
         <link rel="stylesheet" href="assets/css/nexus.css" rel="stylesheet">
         <link rel="stylesheet" href="assets/css/responsive.css" rel="stylesheet">
         <link rel="stylesheet" href="assets/css/custom.css" rel="stylesheet">
          <link rel="stylesheet" href="assets/css/style.css" rel="stylesheet">
         <!-- Google Fonts-->
         <link href="http://fonts.googleapis.com/css?family=Roboto:400,300" rel="stylesheet" type="text/css">
         <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" type="text/css">
     </head>
     <body>
         <div id="body_bg">
             <div id="pre_header" class="container">
                <div class="row margin-top-10 visible-lg">
                </div>
            </div>
            <div class="primary-container-group">
                <!-- Background -->
                <div class="primary-container-background">
                    <div class="primary-container"></div>
                    <div class="clearfix"></div>
                </div>
                <!--End Background -->
                <div class="primary-container">
                    <div id="header" class="container">
                        <div class="row">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="index.php" title="">
                                    <img src="assets/img/logo.png" alt="Logo" />
                                </a>
                            </div>
                            <!-- End Logo -->
                        </div>
                    </div>
                     <!-- Top Menu -->
                     <div id="hornav" class="container no-padding">
                         <div class="row">
                             <div class="col-md-12 no-padding">
                                 <div class="pull-right visible-lg">
                                     <ul id="hornavmenu" class="nav navbar-nav">
                                         <li>
                                             <a href="index.php" class="fa-home">Home</a>
                                         </li>
                                         <li>
                                             <span class="fa-apple">Product</span>
                                             <ul>
                                                  <li>
                                                     <a href="tradisional.php">Tradisional</a>
                                                 </li>
                                                 <li>
                                                     <a href="cookies.php">Cookies</a>
                                                 </li>
                                                 <li>
                                                     <a href="bakery.php">Bakery</a>
                                                 </li>
                                             </ul>
                                         </li>
                                          <li>
                                        <span class="fa-info-circle">Info Pesanan</span>
                                            <ul>
                                                <li>
                                                    <a href="konfirmasi_pembayaran.php" class="fa-shopping-cart">Keranjang Belanja</a>
                                                </li>
                                                <li>
                                                    <a class="fa fa-dropbox fa-2x" href="cek_status.php">Status Pesanan</a>
                                                </li>
                                            </ul>
                                        </li>
                                         <li>
                                             <a href="testimoni.php" class="fa-comments">Testimonials</a>                                           
                                         </li>
                                         <li>
                                             <a href="kontak.php"  class="fa-envelope-o">Contact Us</a>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <!-- End Top Menu -->
                     <!-- === END HEADER === -->
                     <div id="content">
                         <div class="container">
                     <div class="col-md-12">
                         <!-- lihat data -->
                         <div class="panel panel-default panel-scope" id="data_produk">
                             <div class="panel-heading"><h3>Keranjang Belanja</h3></div>
                                 <div class="row">
                                     <div class="col-md-12">
                                     <?php
                                     $id = @$_GET['id'];
                                     $dataproduk = $db->query("SELECT * FROM produk WHERE id='".$id."'") or die ($db->error);
                                     $data = mysqli_fetch_array($dataproduk);
                                    


                                     if(isset($_SESSION['beli'])=='')

                                     {
                                        $hasil=$db->query("INSERT INTO temppembelian (tanggal, namapembeli)  
                                         VALUES('2016-10-05','feisal')"); 
                                         $querybeli=$db->query("SELECT * FROM temppembelian order by idbeli desc");
                                         $databeli=mysqli_fetch_array($querybeli);
                                         $_SESSION['beli']=$databeli['idbeli'];
                                     }

                                     //$jumlah=$_POST['jumlah'];
                                     $jumlah    = (isset($_POST['jumlah'])) ? $_POST['jumlah'] : 0;
                                     
                                     $hasil=$db->query("INSERT INTO tempdetailpembelian (idbeli, id,jumlah)   
                                     VALUES('".$_SESSION['beli']."','".$data['id']."','$jumlah')"); 

                                     ?>
                                     
                                     <?php
                                     include('koneksi.php');
                                     $querypembelian=$db->query("SELECT * FROM temppembelian, tempdetailpembelian, produk where 
                                     temppembelian.idbeli=tempdetailpembelian.idbeli and 
                                     tempdetailpembelian.id=produk.id
                                     and temppembelian.idbeli='".$_SESSION['beli']."'");
                                     echo"<table class='table table-striped'>
                                     <tr>
                                     <th>No</th>
                                     <th>Nama</th>
                                     <th>Harga</th>
                                     <th>Jumlah</th>
                                     <th>Total</th>
                                     </tr>";

                                     $no=0;
                                     $total=0;
                                     while($datapembelian=mysqli_fetch_array($querypembelian)){
                                     $no++;
                                     echo"
                                     <tr>
                                     <td>$no</td>
                                     <td>".$datapembelian['nama']."</td>
                                     <td>".$datapembelian['harga']."</td>
                                     <td>".$datapembelian['jumlah']."</td>
                                     <td>".$datapembelian['harga']*$datapembelian['jumlah']."</td>
                                     </tr>";
                                     $total=$total+($datapembelian['harga']*$datapembelian['jumlah']);
                                     }
                                     echo"
                                     <tr>
                                     <th colspan='4'>Total</th>
                                     <th>$total</th>
                                     </tr>";
                                     echo"</table>";
                                     ?>
                                     <div class="col-lg-12">
                                     <table></br>
                                     <tr>
                                        <form  action='index.php' method='post'>
                                            <td>
                                            <!-- button name="tombol" type="submit" class="btn btn-primary">Belanja lagi</button -->
                                            <input name='tombol' type='submit' class="btn btn-info" value='Belanja Lagi'>&nbsp&nbsp
                                            </td>
                                        </form>
                                        <form  action='delete.php' method='post'>
                                            <td>
                                            <input name='tombol' type='submit' class="btn btn-danger" value='Batal belanja'>&nbsp&nbsp
                                            </td>
                                        </form>
                                        <form action='signup.php' method='post'>
                                            <td>
                                            <?php
                                            $disable = ($total >= 100000) ? "":"disabled";
                                            ?>
                                            <input name='tombol' type='submit' class="btn btn-success" value='Selesai belanja' <?php echo $disable; ?> >
                                            </td>
                                        </form>
                                     </tr>
                                     </table>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         </div>
                         </div>
                          <!-- === END CONTENT === -->
            <!-- Footer Menu -->
            <div id="footer">
                <div class="container">
                    <div class="row">
                        <div id="copyright" class="col-md-4">
                            <p>(c) 2016 Copyright Amelia Roti</p>
                        </div>
                        <div id="footermenu" class="col-md-8">
                            <ul class="list-unstyled list-inline pull-right">
                               <p>Ruko Merpati Residence Jl. Merpati Raya no.25 Sawah Baru Ciputat </p>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer Menu -->
            <!-- JS -->
            <script type="text/javascript" src="assets/js/jquery.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="assets/js/bootstrap.min.js" type="text/javascript"></script>
            <script type="text/javascript" src="assets/js/scripts.js"></script>
            <!-- Isotope - Portfolio Sorting -->
            <script type="text/javascript" src="assets/js/jquery.isotope.js" type="text/javascript"></script>
            <!-- Mobile Menu - Slicknav -->
            <script type="text/javascript" src="assets/js/jquery.slicknav.js" type="text/javascript"></script>
            <!-- Animate on Scroll-->
            <script type="text/javascript" src="assets/js/jquery.visible.js" charset="utf-8"></script>
            <!-- Sticky Div -->
            <script type="text/javascript" src="assets/js/jquery.sticky.js" charset="utf-8"></script>
            <!-- Slimbox2-->
            <script type="text/javascript" src="assets/js/slimbox2.js" charset="utf-8"></script>
            <!-- Modernizr -->
            <script src="assets/js/modernizr.custom.js" type="text/javascript"></script>
            <!-- End JS -->
    </body>
</html>
<!-- === END FOOTER === -->