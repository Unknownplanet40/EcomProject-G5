<div class="modal" id="searchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-scrollable">
        <div class="modal-content bg-body-tertiary bg-opacity-50 bg-blur">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Search</h5>
                <button type="button" class="btn-close py-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-header border-0">
                <div class="input-group flex-nowrap">
                    <input type="text" class="form-control border-1 border-end-0 border-secondary bg-transparent text-body-trertiary fw-bold
                    " id="search-bar" placeholder="Search here...">
                    <button class="btn btn-outline-secondary" type="button" id="search-btn">
                        <svg class="mb-1" width="16" height="16" role="img" aria-label="Search">
                            <use xlink:href="#Search" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="d-none" id="Sresult">
                    <h5 class="modal-title text-center pt-0">Search Results</h5>
                    <ul class="list-group list-group-flush rounded-3 shadow">
                        <?php
                        $resultCount = 6;
                        for ($i = 1; $i < $resultCount; $i++) {
                        ?>
                            <li class="list-group-item list-group-item-action">
                                <a href="#" class="text-decoration-none text-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex">
                                            <img src="../../Assets/Images/testing/temp<?php echo $i; ?>.jpg" height="40" class="me-3 rounded-3">
                                            <div>
                                                <h5 class="mb-0">List group item heading</h5>
                                                <p class="mb-0">Some placeholder content in a paragraph.</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php
                        }

                        if (!$isLogin) { ?>
                            <li class="list-group-item text-center">
                                <button class="btn btn-sm btn-outline-primary">Sign-in to view more</button>
                            </li>
                        <?php } else
                        if ($resultCount > 5) {
                        ?>
                            <li class="list-group-item text-center">
                                <button class="btn btn-sm btn-outline-primary">View More</button>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>