<?php

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
    <title>Ecommers</title>
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
    // Header
    include_once('../Header/Header.php');

    // Modal
    include_once('../Modal/SearchModal.php');
    include_once('../Modal/SizeGuide.php');
    include_once('../Modal/SigninModal.php');
    include_once('../Modal/ProductModal.php');
    ?>

    <!-- Carousel -->
    <div class="container-responsive mt-3 mb-5 px-1">
        <?php include_once('../Carousel/CarouselFrontPage.php'); ?>
    </div>
    <!-- Categories -->
    <div class="mt-4 bg-body-emphasis p-2">
        <div class="container-lg text-center">
            <div class="row align-items-center justify-content-between g-3">
                <div class="col">
                    <a class="text-decoration-none text-body">
                        <div class="card border-0 bg-transparent">
                            <div class="card-body ratio ratio-16x9">
                                <img id="bimg-1" src="" alt="Category Icon" class="img-fluid object-fit-contain">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="text-decoration-none text-body">
                        <div class="card border-0 bg-transparent">
                            <div class="card-body ratio ratio-16x9">
                                <img id="bimg-2" src="" alt="Category Icon" class="img-fluid object-fit-contain">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="text-decoration-none text-body">
                        <div class="card border-0 bg-transparent">
                            <div class="card-body ratio ratio-16x9">
                                <img id="bimg-3" src="" alt="Category Icon" class="img-fluid object-fit-contain">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="text-decoration-none text-body">
                        <div class="card border-0 bg-transparent">
                            <div class="card-body ratio ratio-16x9">
                                <img id="bimg-4" src="" alt="Category Icon" class="img-fluid object-fit-contain">
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="text-decoration-none text-body">
                        <div class="card border-0 bg-transparent">
                            <div class="card-body ratio ratio-16x9">
                                <img id="bimg-5" src="" alt="Category Icon" class="img-fluid object-fit-contain">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Cards -->
    <h1 class="text-center clamp m-5">ALL PRODUCTS</h1>
    <div class="album bg-body-tertiary pt-1">
        <div class="container-lg">
            <div class="row row-cols-1 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3" data-masonry='{"percentPosition": true }'>
                <?php
                $Item = 14;

                for ($i = 1; $i < $Item; $i++) {
                    $OP = rand(1, 1500);
                    $DP = rand(1, 99);
                    // convert to decimal
                    $DP = $OP - ($OP * ($DP / 100));
                    $percent = 100 - (($DP / $OP) * 100);
                    // random number from 0 to 1
                    $AD = rand(0, 1);
                ?>
                    <div class="col">
                        <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#Product">
                            <div class="card pop border-0 bg-body-tertiary">
                                <img src="<?php
                                            for ($j = 0; $j < 1; $j++) {
                                                echo '../../Assets/Images/testing/temp' . $i . '.jpg';
                                            }
                                            ?>" class="bd-placeholder-img card-img-top object-fit-cover" role="img" preserveAspectRatio="xMidYMid slice" focusable="false">
                                <div class="card-body">
                                    <p class="card-title text-center">Product Name <?php echo $i; ?> - Black</p>
                                    <div class="d-flex justify-content-between align-items-center visually-hidden">
                                        <h5 class=" text-primary card-text">₱ <?php echo intval($DP); ?></h5>
                                        <small class="text-body">
                                            <span class="text-decoration-line-through fw-bold">₱ <?php echo $OP; ?></span> - <span class="text-body-secondary"><?php echo intval($percent) . '%'; ?> off </span>
                                        </small>
                                    </div>
                                    <?php
                                    if ($AD == 1) { ?>
                                        <div class="text-center">
                                            <h5>₱ <?php echo intval($DP); ?> - <small class="text-muted text-decoration-line-through">₱<?php echo intval($OP); ?></small></h5>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center">
                                            <h5>₱ <?php echo intval($OP); ?></h5>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
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
    </div>
    <!-- Footer -->
    <?php include_once('../Footer/Footer.php'); ?>
</body>

</html>