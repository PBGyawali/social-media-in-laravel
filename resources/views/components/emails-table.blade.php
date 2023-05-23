<div class="table-responsive">
    <div class="table table-inbox table-hover">										
            @foreach ($emails as $email)
                <a class="text-dark link-dark" href="{{route('support.show',['id'=>$email->getKey()])}}">
                    <div class="row pl-3 border border-light py-2 clickable-row {{ $email->is_read()?'':'unread font-weight-bold' }} " href="{{route('support.show',['id'=>$email->getKey()])}}">
                    <div class="col-1">
                        <input type="checkbox" class="checkmail" data-id="{{$email->getKey()}}">
                    </div>
                    <div class="col-1">
                        <span class="mail-important" data-id="{{$email->getKey()}}"><i class="fa-star {{ !$email->is_important()?'far':'fas text-warning' }}"></i></span>
                    </div>
                    <div class="col-3 name">
                        {!!str_replace($search, "<mark class='bg-primary text-white'>$search</mark>", [$email->full_name,'me,'.($names[array_rand($names)]).'('.rand(1, 10).')'][array_rand([1,2])]);!!}
                    </div>
                    <div class="col-5 subject">
                        {!!str_replace($search, "<mark class='bg-info text-white'>$search</mark>", $email->subject.'-'.$email->message);!!}
                    </div>
                    <div class="col-1">
                        {!! ['','<i class="fa fa-paperclip"></i>'][array_rand([1,2])] !!}
                    </div>
                    <div class="col-1 mail-date">
                        {!!str_replace($search, "<mark class='bg-primary text-white'>$search</mark>", $email->created_at);!!}
                    </div>
                    </div>    
                </a>                                      
            @endforeach	                                                                                        																
        
    </div>
</div>