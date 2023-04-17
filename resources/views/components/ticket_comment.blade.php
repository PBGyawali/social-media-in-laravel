        <div
        @isset($status)
            id="newticketcomment_{{$id}}"
        @endisset
            class=" mb-1">
            <div>
                @empty($profile_image)
                    <i class="fas fa-comment fa-2x "></i>
                @else
                    <img src="{{$profile_image}}" class="rounded-circle mb-3" style="width: 40px; height: 40px;">
                    {{$username}}
                @endempty

                <button type="button"
                    class="btn btn-danger delete btn-sm float-right p-0 px-1"
                    data-id="{{$id}}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <span class="ticketcomments">
                {{$message}}&nbsp;&nbsp;
                @isset($status)
                    <i class="fas fa-check text-success resolved commenticon"></i>
                @endisset
            </span>
            <p>
                <span class="ticketcommentdate">
                    {{$created_at}}
                </span>
            </p>
        </div>