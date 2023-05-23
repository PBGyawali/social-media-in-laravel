<div class="row">
    <div class="col">
        <div class="card alert mb-0 rounded-0" >
            <div class=" d-flex  flex-row-reverse   justify-content-between align-items-center float-right border-0" >
            <div class="dropdown-list-image mr-3 ">
                <img class="rounded-circle" src="<?=auth()->user()->profile_image?>" height="35" width="35">
            </div>
                    <a class="d-flex flex-row-reverse align-items-center w-100 text-left whitespace-normal ">
                        <div class="text-left ">
                            <div class="">
                                <span>
                                    <p class="text-muted text-uppercase">
                                        This message was deleted by the sender
                                    </p>
                                </span>
                            </div>
                            <span class="float-right">
                                <span class="small mb-0  font-weight-bold">
                                    <?= auth()->user()->username?>
                                </span>
                                <p class="small mb-0 d-inline text-gray-500">
                                    -<?=now()->format('H:i')?>
                                </p>
                            </span>
                        </div>
                    </a>
                
            </div>
        </div>
    </div>
</div>
