<div class="modal" id="searchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-dialog-scrollable">
        <div class="modal-content bg-body-tertiary bg-opacity-25 bg-blur-10">
            <div class="modal-header">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Search</h5>
                <button type="button" class="btn-close py-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-header border-0">
                <div class="input-group flex-nowrap">
                    <input type="text" class="form-control border-1 border-end-0 border-secondary bg-transparent text-body-trertiary fw-bold text-light
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
                    <h5 class="modal-title text-center pt-0 mb-2" id="ResultLabel">Search Results</h5>
                    <ul class="list-group list-group-flush rounded-3 shadow" id="SresultList">
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>