<div class="card shadow border-left-info py-2">
    <div class="card-header text-center text-uppercase font-weight-bold text-{{ $class??'info'}}"><strong>total {{$title??''}}</strong></div>
    <div class="card-body text-center" >
        <div class="row align-items-center no-gutters">
            <div class="col mr-2">
                <h1>{!! $value??'No value' !!}</h1>
            </div>
            <div class="col-auto"><i class="fas fa-{{ $icon??'list'}} fa-2x text-{{ $iconclass??'secondary'}}"></i></div>
        </div>
    </div>
</div>