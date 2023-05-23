<li class="dropdown mx-1" role="presentation">
    <div class=" dropdown ">
        <a class="dropdown position-relative mr-2 cursor-pointer " data-toggle="dropdown" aria-expanded="false" >
            <i class="fas fa-bell fa-fw"></i>
            <span id="messagecount" 
            class="badge badge-danger badge-counter position-absolute py-0 pr-1 ml-0 mr-2" 
            style="top:0;right:0;" >
                @isset($alertcount)
                    @if($alertcount>0)
                        {{$alertcount}}
                        @if($alertcount>=4)
                        +
                        @endif
                    @endif
                @endisset
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-list animated grow-in pb-0" role="menu">
            <h6 class="dropdown-header alert-primary text-center">alerts center</h6>
            @if(isset($alerts) &&!$alerts->isEmpty())
                @foreach ($alerts as $key => $alert)
                    <a class="d-flex align-items-center dropdown-item cursor-pointer whitespace-normal">
                        <div class="mr-3">
                            <div class="icon-circle d-none d-sm-inline-block">
                                <i class="fa fa-<?= $alert->icon_class?>"></i>
                            </div>
                        </div>
                        <div>
                            <span class="small text-gray-500"><?= $alert['alert_date']; ?></span>
                            <p class="d-block text-truncate pb-0 mb-0 col-4 col-sm-8 col-md-12" 
                            style="max-width: 450px;"><?= __('alert.'.$alert->type,['name'=>$alert->alert_name,
                            'value'=>$alert->alert_value,'title'=>$alert->alert_value]) ?></p>
                        </div>
                    </a>
                @endforeach
                <a class="text-center dropdown-item small text-gray-500" href="<?=route($side.'alerts')?>">Show All Alerts</a>
            @else
                @include('no_alerts')
            @endif
        </div>
    </div>
</li>
