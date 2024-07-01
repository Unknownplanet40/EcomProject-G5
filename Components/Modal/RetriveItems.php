<div class="modal fade" id="RetriveItems" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content bg-body-tertiary bg-opacity-10 bg-blur-5">
            <div class="modal-body">
                <ul class="list-group list-group-flush rounded-3" id="RetriveList">
                    <li class="list-group-item bg-transparent">
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer border-0 mt-0">
                <button type="button" class="btn btn-sm btn-secondary" id="RetCloseModal" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" disabled id="RetBTN">Retrive Selected Items</button>
            </div>
        </div>
    </div>
</div>