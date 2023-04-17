<div class="row">
    <div class="col-12 col-md-4">
        <h3 class="card-title">{{ucwords(($element.' '.($name??'List')))}}</h3>
    </div>
    <div class="col-5 col-md-3">
        <div class="row input-daterange">
            @if(empty($noreport) && empty($nofilter))
            <div class="col-6 px-sm-0">
                <input type="date" name="from_date" id="from_date" class="form-control form-control-sm" placeholder="From Date" />
            </div>
            <div class="col-6 px-sm-0">
                <input type="date" name="to_date" id="to_date" class="form-control form-control-sm" placeholder="To Date" />
            </div>
            @endif
        </div>
    </div>
    <div class="col-3 col-md-2 px-sm-0 text-center">
        @if(empty($noreport) && empty($nofilter))
        <button type="button"  title="filter by date" id="filter" class="btn btn-info btn-sm pl-sm-1"><i class="fas fa-filter"></i></button>
        @endif
        @empty($norefresh)
            <button type="button"  title="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>
        @endempty
        @isset($reporturl)
            <button type="button" id="report" title="Get Report" data-url="{{$reporturl}}"data-table="{{$table??$element}}"class="btn btn-info btn-sm"><i class="fas fa-print"></i></button>
        @endisset
        @isset($exporturl)
            <button type="button" id="export" data-url="{{$exporturl}}"  class="text-success btn btn-sm p-0"><i class="fas fa-file-csv fa-2x"></i></button>
        @endisset
    </div>
    <div class="col-4 col-md-3  text-right">
        @empty($nobutton)
            @isset($fake)
                <button type="button" id="fake_button" data-element="{{ucwords($element.' '.($extratext??''))}}" data-toggle="modal" data-target="#Modal" class="btn btn-primary rounded btn-sm ">
                    <i class="fas fa-robot""></i> Fake
                </button>
            @endisset
            <button type="button" name="add" id="add_button" data-element="{{ucwords($element.' '.($extratext??''))}}" data-toggle="modal" data-target="#Modal" class="btn btn-success btn-sm">
                <i class="fas fa-{{$buttonicon??'plus'}}"></i> Add
            </button>
        @endempty

    </div>
</div>
