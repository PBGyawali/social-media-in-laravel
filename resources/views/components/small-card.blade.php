<div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
        <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-sm font-weight-bold text-{{ $class??'success'}} text-uppercase mb-1">
                     {{$title??'No title'}}
                </div>
                <div class="h5 mb-0 mt-3 font-weight-bold text-center">{{ $value??'No value' }}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-{{ $icon??'clipboard-list'}} fa-2x"></i>
            </div>
        </div>
    </div>
</div>