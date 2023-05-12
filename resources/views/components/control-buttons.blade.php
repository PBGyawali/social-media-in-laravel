<div align="text-center">
    @if (in_array('view', $buttons))
    <button type="button" class="btn btn-info btn-sm view" title="View {{$prefix}} data"data-id="{{$id}}">
      <i class="fas fa-eye"></i>
    </button>
    @endif
    @if (in_array('update', $buttons))
    <button type="button" class="btn btn-primary mb-1 btn-sm update" data-target="{{$target??''}}" data-prefix="{{ucwords($prefix)}}" data-id="{{$id}}"><i class="fas fa-eye"></i></button>
    @endif
    @if (in_array('delete', $buttons))
      <button type="button"  class="btn btn-danger btn-sm border delete"  data-action="delete" title="Delete {{$prefix}} data" data-id="{{$id}}">
        <i class="fas fa-times"></i>
      </button>
    @endif
    @if (in_array('edit', $buttons))
      @empty($editurl)
        <button type="button" class="btn btn-secondary btn-sm update" data-prefix="{{trim(ucwords($prefix.' '.($extratext??'')))}}" title="Edit {{$prefix}} data" data-id="{{$id}}">
          <i class="fas fa-edit"></i>
        </button>
      @else
        <form  action="{{$editurl}}" class="userlistform" target="_blank" method="post" >
          {{csrf_field()}}
          <input type="hidden" name="id" value="{{$id}}">
        <button type="submit" title="edit"class="fa fa-edit btn btn-primary btn-sm edit_button"  data-id="{{$id}}"></button>
        </form>
      @endempty
    @endif
    @isset($reseturl)
      <button type="button"  class="btn btn-primary btn-sm reset" title="Reset {{$prefix}} password"data-url="{{$reseturl}}" data-id="{{$id}}">
        <i class="fas fa-sync"></i>
      </button>
    @endisset
    @if (in_array('verify', $buttons))
      <button type="button"  class="btn btn-success btn-sm verify" data-id="{{$id}}" title="Verify {{$prefix}}">
        <i class="fas fa-check"></i>
      </button>
    @endif
    @isset($alertsurl)
    <a  href="{{$alertsurl}}" class="btn btn-success btn-sm" title="Show all {{$prefix}} alerts" target="_blank">
      <i class="fas fa-bell"></i>
    </a>
    @endisset
    @isset($activitylogurl)
    <a  href="{{$activitylogurl}}" class="btn btn-success btn-sm" title="Show all {{$prefix}} activity" target="_blank">
      <i class="fas fa-list"></i>
    </a>
    @endisset

    @if (in_array('status', $buttons))
          @if ($status =='active')
            <button type="button" data-prefix="{{$prefix}}" class="btn btn-warning btn-sm  status " title="Disable {{$prefix}}" data-status="inactive" data-id="{{$id}}">
              <i class="fas fa-ban"></i>
            </button>
          @else
            <button type="button" data-prefix="{{$prefix}}" class="btn btn-success btn-sm status " title="Enable {{$prefix}}" data-status="active" data-id="{{$id}}">
              <i class="fas fa-unlock-alt"></i>
            </button>
          @endif
    @endif
</div>

