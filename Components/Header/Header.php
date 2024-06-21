<audio id="backgroundMusic" loop autoplay>
    <source src="../../Assets/Audio/BG Music.wav" type="audio/wav" />
</audio>
<button id="play" hidden>Play</button>
<nav class="navbar navbar-expand-lg bg-body-tertiary bg-opacity-50 bg-blur-3 border-bottom shadow-sm fixed-top">
    <div class="container-fluid">
        <div class="col-md-3 mb-2 mb-md-0 me-5">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-inline-flex link-body-emphasis text-decoration-none">
                <img class="mx-3" src="../../Assets/Images/Logo_1.png" height="40">
            </a>
        </div>
        <button class="navbar-toggler nb-t" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="nav me-auto mb-2 mb-lg-0 links">
                <li data-bs-toggle="tooltip" data-bs-title="Home" data-bs-placement="bottom" data-bs-trigger="hover" <?php echo (strpos($_SERVER['PHP_SELF'], 'Homepage.php') !== false) ? 'class="visually-hidden"' : ''; ?>>
                    <a class="nav-link px-2 link-hover text-body-emphasis" href="../../Components/Home/Homepage.php">
                        <svg class="mb-1" width="16" height="16" role="img" aria-label="Home">
                            <use xlink:href="#home" />
                        </svg>
                        <span> Home</span>
                    </a>
                </li>
                <li data-bs-toggle="tooltip" data-bs-title="Shop All" data-bs-placement="bottom" data-bs-trigger="hover" <?php echo (strpos($_SERVER['PHP_SELF'], 'Products.php') !== false) ? 'class="visually-hidden"' : ''; ?>>
                    <a href="../../Components/Products/Products.php" class="nav-link px-2 link-hover text-body-emphasis">
                        <svg class="mb-1" width="16" height="16" role="img" aria-label="Shop">
                            <use xlink:href="#Shop" />
                        </svg>
                        <span> Shop All</span>
                    </a>
                </li>
                <li data-bs-toggle="tooltip" data-bs-title="Playaz Tees" data-bs-placement="bottom" data-bs-trigger="hover" <?php echo (strpos($_SERVER['PHP_SELF'], 'PlayazTees.php') !== false) ? 'class="visually-hidden"' : ''; ?>>
                    <a href="#" class="nav-link px-2 link-hover text-body-emphasis">
                        <svg class="mb-1" width="16" height="16" role="img" aria-label="Size">
                            <use xlink:href="#Cloth" />
                        </svg>
                        <span> Playaz Tees</span>
                    </a>
                </li>
                <li data-bs-toggle="tooltip" data-bs-title="Size Guide" data-bs-placement="bottom" data-bs-trigger="hover">
                    <a href="#" data-bs-target="#Sizechart" data-bs-toggle="modal" class="nav-link px-2 link-hover text-body-emphasis">
                        <svg class="mb-1" width="16" height="16" role="img" aria-label="Size">
                            <use xlink:href="#Size" />
                        </svg>
                        <span> Size Guide</span>
                    </a>
                </li>
                <li data-bs-toggle="tooltip" data-bs-title="Search Products" data-bs-placement="bottom" data-bs-trigger="hover"><a id="Hsearch" href="#" data-bs-target="#searchModal" data-bs-toggle="modal" class="nav-link px-2 link-hover text-body-emphasis <?php echo (strpos($_SERVER['PHP_SELF'], 'Products.php') !== false) ? 'visually-hidden' : ''; ?>">
                        <svg class="mb-1" width="18" height="18" role="img" aria-label="Search">
                            <use xlink:href="#Search" />
                        </svg>
                        <span> Search</span>
                    </a>
                </li>
            </ul>
            <div class="d-flex justify-content-end">
                <?php
                if (!$login) { ?>
                    <a href=" #" data-bs-target="#SignIN" data-bs-toggle="modal" class="d-block link-body-emphasis text-decoration-none">
                        <svg class="" width="16" height="16" role="img" aria-label="Register">
                            <use xlink:href="#Login" />
                        </svg> Sign In / Register
                    </a>
                <?php } else {
                    $haveCart = false;
                    $CartItem = 0;

                    $stmt = $conn->prepare("SELECT * FROM user_shoppingcart WHERE User_ID = ? AND Status IS NULL");
                    $stmt->bind_param("s", $_SESSION['User_Data']['user_ID']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $CartItem = $result->num_rows; ?>
                    <div class="hstack gap-3">
                        <div class="me-3 position-relative" id="cart-btn">
                            <a class="d-block link-body-emphasis text-decoration-none mt-1" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-2 text-bg-primary bg-opacity-75">
                                    <span id="Cart-Items"><?php echo $CartItem; ?></span>
                                    <span class="visually-hidden">Items in cart</span>
                                </span>
                                <svg class="mb-1" width="24" height="24" role="img" aria-label="Cart">
                                    <use xlink:href="#Cart" />
                                </svg>
                            </a>
                        </div>
                        <div>
                            <?php if ($UserRole == "user" && $haveAddress == 0) { ?>
                                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle position-relative" data-bs-toggle="dropdown">
                                    <?php if ($has_profile) { ?>
                                        <img src="<?php echo $profile; ?>" alt="Profile" width="32" height="32" class="rounded-circle">
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                            <span class="visually-hidden">Important</span>
                                        </span>
                                    <?php } else { ?>
                                        <img src="../../Assets/Images/Profile.gif" alt="Profile" width="32" height="32" class="rounded-circle">
                                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                            <span class="visually-hidden">Important</span>
                                        </span>
                                    <?php } ?>
                                </a>
                            <?php } else { ?>
                                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                    <?php if ($has_profile) { ?>
                                        <img src="<?php echo $profile; ?>" alt="Profile" width="32" height="32" class="rounded-circle">
                                    <?php } else { ?>
                                        <img src="../../Assets/Images/Profile.gif" alt="Profile" width="32" height="32" class="rounded-circle">
                                    <?php } ?>
                                </a>
                            <?php } ?>
                            <ul class="dropdown-menu text-small shadow dropdown-menu-end">
                                <li>
                                    <h3 class="dropdown-header">
                                        <div class="d-flex justify-content-center">
                                            <?php if ($has_profile) { ?>
                                                <img src="<?php echo $profile; ?>" alt="Profile" width="48" height="48" class="rounded-circle">
                                            <?php } else { ?>
                                                <img src="../../Assets/Images/Profile.gif" alt="Profile" width="48" height="48" class="rounded-circle">
                                            <?php } ?>
                                        </div>
                                        <div class="d-flex justify-content-center" style="max-width: 200px;">
                                            <p class="dropdown-item-text px-2 text-truncate fw-bold fs-6" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-trigger="hover" data-bs-title="<?php echo $Username; ?>"><?php echo $Username; ?></p>
                                        </div>
                                        <?php if ($UserRole == "admin") { ?>
                                            <div class="text-center" style="margin-top: -15px;">
                                                <small class="text-muted">Administrator</small>
                                            </div>
                                        <?php } else if ($UserRole == "seller") { ?>
                                            <div class="text-center" style="margin-top: -15px;">
                                                <small class="text-muted">Brand Seller</small>
                                            </div>
                                        <?php } else { ?>
                                            <div class="text-center" style="margin-top: -15px;">
                                                <small class="text-muted">Last Login: <?php echo $Last_Login; ?></small>
                                            </div>
                                        <?php } ?>
                                    </h3>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <?php if ($UserRole == "admin") { ?>
                                    <li><a class="dropdown-item dropdown-item-text" href="../Admin/Dashboard/Dashboard.php">Dashboard</a></li>
                                <?php } else if ($UserRole == "seller") { ?>
                                    <li><a class="dropdown-item dropdown-item-text" href="../Admin/Products/Product_Inv.php">Products Dashboard</a></li>
                                <?php } ?>
                                <li><a class="dropdown-item dropdown-item-text" href="../../Components/Profile/General_Setting.php">Settings</a></li>
                                <li><a class="dropdown-item dropdown-item-text" href="#">My Orders</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item dropdown-item-text text-center" href="../Signout/Logout.php">
                                        <svg class="my-1" width="16" height="16" role="img" aria-label="Logout">
                                            <use xlink:href="#Logout" />
                                        </svg> Sign out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
</nav>
<!-- Offcanvas Cart -->
<div class="offcanvas-size offcanvas offcanvas-end bg-blur-10 bg-opacity-50 bg-body-tertiary" data-bs-backdrop="static" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Your Shopping Cart <span class="badge bg-primary rounded-2"><span id="Ccount"><?php echo $CartItem; ?></span> Items</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body overflow-auto rounded-2 items-scroll">
        <div class="row">
            <div class="col-12">
                <div>
                    <ul class="list-group list-group-flush rounded-2 bg-transparent" id="UserCart">
                        <li class="list-group-item bg-transparent border-0">
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer my-3">
        <div class=" vstack gap-2 col-10 mx-auto">
            <button id="tocheckout" type="button" class="btn btn-primary" <?php echo ($CartItem == 0) ? 'disabled' : ''; ?>>Proceed to Checkout</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Continue Shopping</button>
        </div>
    </div>
</div>
<hr style="height: 64px; margin: 0;">