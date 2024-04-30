<?php

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Third-party Stylesheet/Scripts -->
    <link rel="stylesheet" href="../../Utilities/Third-party/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../Utilities/Third-party/sweetalert2/css/sweetalert2.min.css">
    <script defer src="../../Utilities/Third-party/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../../Utilities/Third-party/sweetalert2/js/sweetalert2.all.min.js"></script>
    <script src="../../Utilities/Third-party/masonry/js/masonry.pkgd.js"></script>
    <!-- Main Stylesheet/Scripts -->
    <link rel="stylesheet" href="../../Utilities/Stylesheets/HomeStyle.css">
    <script defer src="../../Utilities/Scripts/HomeScript.js"></script>
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
    <div class="container mt-4 border border-3 rounded-2">
        <div class="hstack gap-3 p-3 justify-content-center">
            <a href="#" class="text-decoration-none text-body">
                <div class="card">
                    <div class="card-body">
                        DBTK Logo
                    </div>
                </div>
            </a>
            <a href="#" class="text-decoration-none text-body">
                <div class="card">
                    <div class="card-body">
                        UNDFTD Logo
                    </div>
                </div>
            </a>
            <a href="#" class="text-decoration-none text-body">
                <div class="card">
                    <div class="card-body">
                        COZIEST Logo
                    </div>
                </div>
            </a>
            <a href="#" class="text-decoration-none text-body">
                <div class="card">
                    <div class="card-body">
                        RICHBOYZ Logo
                    </div>
                </div>
            </a>
            <a href="#" class="text-decoration-none text-body">
                <div class="card">
                    <div class="card-body">
                        MFCKN kids Logo
                    </div>
                </div>
            </a>
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
                    $OP = rand(1, 500);
                    $DP = rand(1, 99);
                    // convert to decimal
                    $DP = $OP - ($OP * ($DP / 100));
                    $percent = 100 - (($DP / $OP) * 100);
                ?>
                    <div class="col">
                        <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#Product">
                            <div class="card pop border-0">
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
                                    <div class="text-center">
                                        <h5>₱ <?php echo intval($OP); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include_once('../Footer/Footer.php'); ?>
</body>

</html>