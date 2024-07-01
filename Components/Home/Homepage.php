<?php
session_start();
include_once '../../Databases/DB_Configurations.php';

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';
$Theme = 'light';
$haveAddress = 0;
$profile = 'Undefined';
$has_profile = false;

if (isset($_SESSION['User_Data'])) {
    if ($_SESSION['User_Data']['Is_user_logged_in'] == 1) {
        $login = true;
        $Username = $_SESSION['User_Data']['First_Name'] . ' ' . $_SESSION['User_Data']['Last_Name'];
        $Last_Login = date('F j, Y', strtotime($_SESSION['User_Data']['Last_Login']));
        $UserRole = $_SESSION['User_Data']['Role'];
        $haveAddress = $_SESSION['User_Data']['HaveAddress'];
        $Theme = $_SESSION['User_Data']['User_Settings']['Theme'];
        $profile = $_SESSION['User_Data']['Profile'];
        $has_profile = $_SESSION['User_Data']['Has_Profile'];
        echo '<script>var Is_User_Logged_In = true;</script>';
        echo '<script>var User_ID = "' . $_SESSION['User_Data']['user_ID'] . '";</script>';
    }
} else {
    echo '<script>var Is_User_Logged_In = false;</script>';
    echo '<script>var User_ID = 0;</script>';
}
?>


<!DOCTYPE html>

<html lang="en" data-bs-theme="<?php echo $Theme; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Third-party Stylesheet/Scripts -->
    <?php include_once '../../Utilities/Third-party/Import-ThirdParty.php'; ?>
    <!-- Main Stylesheet/Scripts -->
    <link rel="stylesheet" href="../../Utilities/Stylesheets/HomeStyle.css">
    <link rel="stylesheet" href="../../Utilities/Stylesheets/Gallery.css">
    <script defer src="../../Utilities/Scripts/HomeScript.js"></script>
    <!-- <script defer src="../../Utilities/Scripts/ToggleSwitch.js"></script> -->
    <script defer src="../../Utilities/Scripts/LoginScript.js"></script>
    <link rel="manifest" href="manifest.json">
    <link rel="shortcut icon" href="../../Assets/Icons/Logo_1_x128.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="../../Assets/Images/Logo_1x144.png">
    <title>Ecommers</title>
    <script>
        // clear specific local storage
        localStorage.removeItem('FileName');
        //get file mame and set it as the title
        var FileName = document.location.pathname.split('/').slice(-1)[0];
        // save to local storage
        localStorage.setItem('FileName', FileName);
    </script>
</head>

<?php include_once '../../Assets/Icons/Icon_Assets.php'; ?>

<body class="bg-body-tertiary" id="cBody" style="overflow: hidden;">
    <div id="devtool" class="visually-hidden">
        <div class="Cmodal-backdrop Cfade Cshow"></div>
        <span class="custom-devtool">
            <p class="text-center">We can't allow you to inspect the code</p>
        </span>
    </div>
    <div id="loader" class="d-block">
        <div class="Cmodal-backdrop Cfade Cshow"></div>
        <span class="custom-loader"></span>
    </div>
    <?php
    // Alert
    include_once '../SweetAlerts/Sweetalert.php';

    // Header
    include_once '../Header/Header.php';

    // Modal
    include_once '../Modal/SearchModal.php';
    include_once '../Modal/SizeGuide.php';
    include_once '../Modal/SigninModal.php';
    include_once '../Modal/ProductModal.php';
    ?>

    <!-- Carousel -->
    <div class="container-xxl mt-3 mb-5 px-1 d-none d-md-block">
        <?php include_once '../Carousel/CarouselFrontPage.php'; ?>
    </div>
    <!-- Brands Icons -->
    <div class="mt-4 bg-body-emphasis p-2">
        <div class="container-lg text-center">
            <div class="row align-items-center justify-content-between g-3">
                <!-- for Loop to remove repetitive code -->
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <div class="col">
                        <a class="text-decoration-none text-body">
                            <div class="card border-0 bg-transparent">
                                <div class="card-body ratio ratio-16x9">
                                    <img id="bimg-<?php echo $i; ?>" src="../../Assets/Images/Alternative.gif" alt="Category Icon" class="img-fluid object-fit-contain" loading="lazy">
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Product Cards -->
    <h1 class="text-center clamp m-5">Most Popular Products</h1>
    <div class="album bg-body-tertiary pt-1">
        <div class="container-lg">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-col-xxl-6 g-3" data-masonry='{"percentPosition": true }'>
                <?php

                $stmt_count = $conn->prepare("SELECT COUNT(id) AS Item FROM product WHERE Status = 0");
                $stmt_count->execute();
                $stmt_count->store_result();
                $stmt_count->bind_result($Item);
                $stmt_count->fetch();
                $stmt_count->close();

                if ($Item > 0) {
                    function fetchImage($conn, $ID, $order)
                    {
                        $result = mysqli_query($conn, "SELECT Image_File FROM product_image WHERE UID = '$ID' AND Image_Order = $order");
                        if ($result && mysqli_num_rows($result) > 0) {
                            $imageFile = mysqli_fetch_assoc($result)['Image_File'];
                            return "data:image/jpg;charset=utf8;base64," . base64_encode($imageFile);
                        } else {
                            return '../../Assets/Images/Alternative.gif';
                        }
                    }

                    // change popularity to [100] to show the most popular products
                    $stmt_prod = $conn->prepare("SELECT * FROM product WHERE Status = 0 AND Popularity != 0 ORDER BY Popularity DESC LIMIT 8");
                    $stmt_prod->execute();
                    $result = $stmt_prod->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $ID = $row['UID'];
                        $Name = $row['Prod_Name'];
                        $Brand = $row['Brand'];
                        $Price = $row['Price'];
                        $Color = $row['Color'];
                        $Image = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Image_File FROM product_image WHERE UID = '$ID' AND Image_Order = 1"))['Image_File'];

                        $Stock = "SELECT (S_Qty + M_Qty + L_Qty + XL_Qty) AS Stock FROM product_size WHERE UID = '$ID'";
                        $Stock = mysqli_fetch_assoc(mysqli_query($conn, $Stock))['Stock']; ?>

                        <div class="col">
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#Product" id="Pmodal_<?php echo $ID; ?>">
                                <div class="card pop border-0 bg-body-tertiary">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($Image); ?>" class="bd-placeholder-img card-img-top object-fit-cover rounded" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" loading="lazy">
                                    <div class="card-body">
                                        <p class="card-title text-center"><?php echo $Name; ?></p>
                                        <div class="text-center">
                                            <h5>₱ <?php echo intval($Price); ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <script>
                            document.getElementById('Pmodal_<?php echo $ID; ?>').addEventListener('click', function() {
                                var ID = '<?php echo $ID; ?>';
                                var Name = '<?php echo $Name; ?>';
                                var Brand = '<?php echo $Brand; ?>';
                                var Price = '<?php echo $Price; ?>';
                                var Color = '<?php echo $Color; ?>';

                                // reset the modal before opening
                                document.getElementById('ProductID').value = '';
                                document.getElementById('SS').hidden = true;
                                document.getElementById('SM').hidden = true;
                                document.getElementById('SL').hidden = true;
                                document.getElementById('SXL').hidden = true;
                                document.getElementById('Selectsize').selectedIndex = 0;
                                document.getElementById('Qinput').value = 1;
                                document.getElementById('Qinput').setAttribute('max', 1);
                                document.getElementById('AvailStat').classList.remove('bg-success', 'bg-danger');
                                document.getElementById('AddCart').classList.add('disabled');

                                // set the values
                                document.getElementById('ProductID').value = ID;
                                document.getElementById('Pic-main').src = '<?php echo fetchImage($conn, $ID, 1); ?>';
                                document.getElementById('Pic-1').src = '<?php echo fetchImage($conn, $ID, 1); ?>';
                                document.getElementById('Pic-2').src = '<?php echo fetchImage($conn, $ID, 2); ?>';
                                document.getElementById('Pic-3').src = '<?php echo fetchImage($conn, $ID, 3); ?>';
                                document.getElementById('Pic-4').src = '<?php echo fetchImage($conn, $ID, 4); ?>';

                                document.getElementById('Pname').textContent = Name;
                                document.getElementById('Pbrand').textContent = Brand;
                                document.getElementById('Pcolor').textContent = Color;

                                <?php if ($Stock > 0) { ?> document.getElementById('AvailStat').textContent = 'In Stock';
                                    document.getElementById('AvailStat').classList.add('bg-success');
                                <?php } else { ?> document.getElementById('AvailStat').textContent = 'Out of Stock';
                                    document.getElementById('AvailStat').classList.add('bg-danger');
                                <?php } ?>

                                document.getElementById('Pprice').textContent = Price;
                                document.getElementById('PriceItem').textContent = Price;

                                <?php
                                $size_result = mysqli_query($conn, "SELECT * FROM product_size WHERE UID = '$ID'");
                                while ($row = mysqli_fetch_assoc($size_result)) {
                                    // available quantities
                                    $s_Q = $row['S_Qty'];
                                    $m_Q = $row['M_Qty'];
                                    $l_Q = $row['L_Qty'];
                                    $xl_Q = $row['XL_Qty'];

                                    if ($s_Q != 0) { ?> document.getElementById('SS').hidden = false;
                                        document.getElementById('SS').setAttribute('data-Qty', '<?php echo $s_Q; ?>');
                                    <?php } ?>

                                    <?php if ($m_Q != 0) { ?> document.getElementById('SM').hidden = false;
                                        document.getElementById('SM').setAttribute('data-Qty', '<?php echo $m_Q; ?>');
                                    <?php } ?>

                                    <?php if ($l_Q != 0) { ?> document.getElementById('SL').hidden = false;
                                        document.getElementById('SL').setAttribute('data-Qty', '<?php echo $l_Q; ?>');
                                    <?php } ?>

                                    <?php if ($xl_Q != 0) { ?> document.getElementById('SXL').hidden = false;
                                        document.getElementById('SXL').setAttribute('data-Qty', '<?php echo $xl_Q; ?>');
                                <?php }
                                }
                                ?>

                            });
                        </script>
                    <?php
                    }
                } else {
                    for ($i = 0; $i < 5; $i++) { ?>
                        <!--
                            If No Products are Available or
                            the Database is Empty or
                            There is an Error
                        -->
                        <div class="col">
                            <a class="text-decoration-none">
                                <div class="card border-0 bg-body-tertiary">
                                    <span class="placeholder-glow">
                                        <span class="placeholder bd-placeholder-img card-img-top rounded" style="height: 128px;" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" loading="lazy"></span>
                                    </span>
                                    <div class="card-body">
                                        <p class="card-title text-center placeholder-wave">
                                            <span class="placeholder col-10 rounded"></span>
                                        </p>
                                        <h5 class="card-text placeholder-wave text-center">
                                            <span class="placeholder col-4 rounded"></span>
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>
    <h1 class="text-center clamp m-5">Gallery</h1>
    <div class="album bg-body-tertiary pt-1">
        <div class="modal" id="inlage" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 bg-body-tertiary bg-opacity-10 bg-blur-5">
                    <div class="modal-body">
                        <img src="../../Assets/Images/Alternative.gif" id="preview-inlage" alt="Gallery Image" class="img-fluid object-fit-cover" width="100%" data-bs-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-lg">
            <div class="row row-cols-3 row-cols-sm-4 row-cols-md-5 row-cols-lg-6 row-col-xxl-7 g-3" data-masonry='{"percentPosition": true }'>
                <?php
                // count the number of images in the gallery folder
                $dir = '../../Assets/Products_Assets/Gallery/';
                $files = glob($dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                $filecount = count($files);
                for ($i = 1; $i <= $filecount; $i++) { ?>
                    <div class="col">
                        <img src="../../Assets/Products_Assets/Gallery/StockImage <?php echo $i; ?>.jpg" alt="Gallery Image" class="img-fluid object-fit-cover gal-img">
                    </div>
                <?php } ?>
            </div>
        </div>

        <script>
            var modal = document.getElementById('inlage');
            var img = document.getElementsByClassName('gal-img');
            var modalImg = document.getElementById('preview-inlage');

            for (var i = 0; i < img.length; i++) {
                img[i].onclick = function() {
                    modal.style.display = 'block';
                    modalImg.src = this.src;
                }
            }

            modal.onclick = function() {
                modal.style.display = 'none';
            }
        </script>
    </div>
    <!-- Footer -->
    <?php include_once '../Footer/Footer.php'; ?>
</body>

</html>