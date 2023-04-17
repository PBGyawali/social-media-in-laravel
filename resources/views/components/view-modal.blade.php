<div class="table-responsive">
    <table class="table table-bordered">
        @foreach ($viewdatas as $key => $viewdata )
        <tr>
            @if(in_array($key,['Status','Email status','Profile Verification status']))
            <td>{{ucwords($key)}}</td>
            <td><span class="badge badge-{{$viewdata['class']}}">{{ $viewdata['value'] }}</span></td>
            @elseif($key=='image')
            <td>{{ucwords($key)}}</td>
            <td>
                <img id="profile_image" 
                     src="{{$viewdata}}" 
                     class="rounded-circle mb-0 mt-0 img-fluid" 
                     width="200" 
                     alt="thumbnail"
                >
            </td>
            @elseif($key=='remarks')
            <td>{{ucwords($key)}}</td>
            <td><textarea name="remarks" id="remarks" class="form-control" data-parsley-maxlength="400" data-parsley-trigger="keyup">{{$viewdata}}</textarea></td>
            @else
            <td>{{ucwords($key)}}</td>
            <td>{{ucwords($viewdata)}}</td>
            @endif
        </tr>
        @endforeach
    </table>
</div>
