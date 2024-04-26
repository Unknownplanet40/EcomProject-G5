<nav class="navbar navbar-expand-lg bg-body-tertiary bg-opacity-25 bg-blur border-bottom shadow-sm fixed-top">
    <div class="container-fluid">
        <div class="col-md-3 mb-2 mb-md-0">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-inline-flex link-body-emphasis text-decoration-none">
                <img class="mx-3" src="../../Assets/Images/Logo_1.png" height="40">
            </a>
        </div>
        <button class="navbar-toggler nb-t" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="nav me-auto mb-2 mb-lg-0">
                <li><a href="#" class="nav-link px-2 link-hover active-tab"><svg class="mb-1" width="16" height="16" role="img" aria-label="Home">
                            <use xlink:href="#home" />
                        </svg> Home</a></li>
                <li><a href="#" class="nav-link px-2 link-hover"><svg class="mb-1" width="16" height="16" role="img" aria-label="Shop">
                            <use xlink:href="#Shop" />
                        </svg> Shop All</a></li>
                <li><a href="#" class="nav-link px-2 link-hover"><svg class="mb-1" width="16" height="16" role="img" aria-label="Size">
                            <use xlink:href="#Cloth" />
                        </svg> Playaz Tees</a></li>
                <li><a href="#" data-bs-target="#Sizechart" data-bs-toggle="modal" class="nav-link px-2 link-hover"><svg class="mb-1" width="16" height="16" role="img" aria-label="Size">
                            <use xlink:href="#Size" />
                        </svg> Size Guide</a></li>
                <li><a id="Hsearch" href="#" data-bs-target="#searchModal" data-bs-toggle="modal" class="nav-link px-2 link-hover"><svg class="mb-1" width="18" height="18" role="img" aria-label="Search">
                            <use xlink:href="#Search" />
                        </svg> Search</a></li>
            </ul>

            <div class="text-end mx-3">
                <?php
                //[temporary] Check if user is logged in
                $isLogin = false;
                $haveCart = false;

                if (!$isLogin) { ?>
                    <a href="#" data-bs-target="#SignIN" data-bs-toggle="modal" class="d-block link-body-emphasis text-decoration-none">
                        <svg class="" width="16" height="16" role="img" aria-label="Register">
                            <use xlink:href="#Login" />
                        </svg> Sign In / Register
                    </a>
                <?php } else { ?>
                    <!-- If Login-->
                    <div class="hstack gap-3">
                        <?php if ($haveCart) { ?>
                            <div class="me-3 position-relative">
                                <a href="#" class="d-block link-body-emphasis text-decoration-none mt-1">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-2 text-bg-primary bg-opacity-75">
                                        99+
                                        <span class="visually-hidden">Items in cart</span>
                                    </span>
                                    <svg class="mb-1" width="24" height="24" role="img" aria-label="Cart">
                                        <use xlink:href="#Cart" />
                                    </svg>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="me-3" title="Cart is empty">
                                <a href="#" class="d-block link-body-emphasis text-decoration-none mt-1">
                                    <svg class="mb-1" width="24" height="24" role="img" aria-label="Cart">
                                        <use xlink:href="#Cart" />
                                    </svg>
                                </a>
                            </div>
                        <?php } ?>
                        <div>
                            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu text-small shadow dropdown-menu-end">
                                <li>
                                    <p class="dropdown-header">Welcome,</p>
                                    <p class="dropdown-item-text px-2">Lorem Ipsum Dolor</p>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">About Us</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
<hr style="height: 64px; margin: 0;">