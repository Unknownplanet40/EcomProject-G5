<?php
session_start();
include_once('../../Databases/DB_Configurations.php');

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';

if (isset($_SESSION['User_Data'])) {
    if ($_SESSION['User_Data']['Is_user_logged_in'] == 1) {
        $login = true;
        $Username = $_SESSION['User_Data']['First_Name'] . ' ' . $_SESSION['User_Data']['Last_Name'];  
        // format last login date to this format "January 1, 2021"
        $Last_Login = date('F j, Y', strtotime($_SESSION['User_Data']['Last_Login']));
        $UserRole = $_SESSION['User_Data']['Role'];
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Third-party Stylesheet/Scripts -->
    <?php include_once('../../Utilities/Third-party/Import-ThirdParty.php'); ?>
    <!-- Main Stylesheet/Scripts -->
    <link rel="stylesheet" href="../../Utilities/Stylesheets/HomeStyle.css">
    <script defer src="../../Utilities/Scripts/HomeScript.js"></script>
    <script defer src="../../Utilities/Scripts/ToggleSwitch.js"></script>
    <script defer src="../../Utilities/Scripts/LoginScript.js"></script>
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

<?php include_once('../../Assets/Icons/Icon_Assets.php'); ?>

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
    include_once('../SweetAlerts/Sweetalert.php');

    // Header
    include_once('../Header/Header.php');

    // Modal
    include_once('../Modal/SearchModal.php');
    include_once('../Modal/SizeGuide.php');
    include_once('../Modal/SigninModal.php');
    include_once('../Modal/ProductModal.php');
    ?>

    <!-- Carousel -->
    <div class="container-xxl mt-3 mb-5 px-1">
        <?php include_once('../Carousel/CarouselFrontPage.php'); ?>
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
                                    <img id="bimg-<?php echo $i; ?>" src="https://ssl.gstatic.com/accounts/ui/progress_spinner_color_20dp_4x.gif" alt="Category Icon" class="img-fluid object-fit-contain" loading="lazy">
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Product Cards -->
    <h1 class="text-center clamp m-5">ALL PRODUCTS</h1>
    <div class="album bg-body-tertiary pt-1">
        <div class="container-lg">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-col-xxl-6 g-3" data-masonry='{"percentPosition": true }'>
                <?php
                $sql = "SELECT COUNT(id) AS Item FROM product";
                $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                $Item = $row['Item'];

                if ($Item > 0) {
                    // get the product data
                    $sql = "SELECT * FROM product";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $ID = $row['UID'];
                        $Name = $row['Prod_Name'];
                        $Brand = $row['Brand'];
                        $Price = $row['Price'];
                        $Image = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Image_File FROM product_image WHERE UID = '$ID' AND Image_Order = 1"))['Image_File'];

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
                        $Stock = "SELECT (S_Qty + M_Qty + L_Qty + XL_Qty) AS Stock FROM product_size WHERE UID = '$ID'";
                        $Stock = mysqli_fetch_assoc(mysqli_query($conn, $Stock))['Stock']; ?>

                        <div class="col">
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#Product" id="Pmodal_<?php echo $ID; ?>">
                                <div class="card pop border-0 bg-body-tertiary">
                                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($Image); ?>" class="bd-placeholder-img card-img-top object-fit-cover rounded" role="img" preserveAspectRatio="xMidYMid slice" focusable="false" loading="lazy">
                                    <div class="card-body">
                                        <p class="card-title text-center"><?php echo $Name; ?> - <?php echo $Brand; ?></p>
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

                                document.getElementById('ProductID').value = ID;
                                document.getElementById('Pic-main').src = '<?php echo fetchImage($conn, $ID, 1); ?>';
                                document.getElementById('Pic-1').src = '<?php echo fetchImage($conn, $ID, 1); ?>';
                                document.getElementById('Pic-2').src = '<?php echo fetchImage($conn, $ID, 2); ?>';
                                document.getElementById('Pic-3').src = '<?php echo fetchImage($conn, $ID, 3); ?>';
                                document.getElementById('Pic-4').src = '<?php echo fetchImage($conn, $ID, 4); ?>';

                                document.getElementById('Pname').textContent = Name;
                                document.getElementById('Pbrand').textContent = Brand;

                                <?php if ($Stock > 0) { ?>
                                    document.getElementById('AvailStat').textContent = 'In Stock';
                                    document.getElementById('AvailStat').classList.add('bg-success');
                                <?php } else { ?>
                                    document.getElementById('AvailStat').textContent = 'Out of Stock';
                                    document.getElementById('AvailStat').classList.add('bg-danger');
                                <?php } ?>

                                document.getElementById('Pprice').textContent = Price + '.00';
                                document.getElementById('PriceItem').textContent = Price;

                                <?php
                                $size_query = "SELECT * FROM product_size WHERE UID = '$ID'";
                                $size_result = mysqli_query($conn, $size_query);

                                while ($row = mysqli_fetch_assoc($size_result)) {
                                    // available sizes
                                    $s = $row['S'];
                                    $m = $row['M'];
                                    $l = $row['L'];
                                    $xl = $row['XL'];

                                    // available quantities
                                    $s_Q = $row['S_Qty'];
                                    $m_Q = $row['M_Qty'];
                                    $l_Q = $row['L_Qty'];
                                    $xl_Q = $row['XL_Qty'];

                                    if ($s != 0) { ?>
                                        document.getElementById('SS').hidden = false;
                                        document.getElementById('SS').setAttribute('data-Qty', '<?php echo $s_Q; ?>');
                                    <?php } ?>

                                    <?php if ($m != 0) { ?>
                                        document.getElementById('SM').hidden = false;
                                        document.getElementById('SM').setAttribute('data-Qty', '<?php echo $m_Q; ?>');
                                    <?php } ?>

                                    <?php if ($l != 0) { ?>
                                        document.getElementById('SL').hidden = false;
                                        document.getElementById('SL').setAttribute('data-Qty', '<?php echo $l_Q; ?>');
                                    <?php } ?>

                                    <?php if ($xl != 0) { ?>
                                        document.getElementById('SXL').hidden = false;
                                        document.getElementById('SXL').setAttribute('data-Qty', '<?php echo $xl_Q; ?>');
                                        document.getElementById('SXL').textContent = 'Extra Large - (' + '<?php echo $xl_Q; ?>' + ' Available)';
                                <?php }
                                }
                                ?>

                            });
                        </script>
                    <?php }
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
                <?php  }
                }
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
    <!-- Debugging Purposes -->
    <div class="container mt-4 bg-body-secondary rounded-2 p-2">
        <p class="text-center text-body-secondary">*Note: For UI testing purposes only until the backend is ready to be integrated</p>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="light-dark">
            <label class="form-check-label" for="light-dark" id="light-dark-label">Switch to Dark Mode - <small class="text-muted">*Note: This will be Included via Settings</small></label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="login-out">
            <label class="form-check-label" for="login-out" id="login-out-label">Switch to Login Mode</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="cart-status" disabled>
            <label class="form-check-label" for="cart-status" id="cart-status-label">Switch to Cart Status</label>
        </div>
        <button id="ShowToast" type="button" class="btn btn-sm btn-primary">Show Toast</button>
        <label class="form-check-label mt-1" for="cart-status" id="ShowToast">Show SweetAlert2 Toast</label>

    </div>
    <!-- Footer -->
    <?php include_once('../Footer/Footer.php'); ?>
</body>

</html>