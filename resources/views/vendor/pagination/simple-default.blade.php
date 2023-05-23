@if ($paginator->hasPages())
    <nav>
        <ul class="pagination h4 justify-content-between">                  
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="btn disabled">
                    <i class="fa fa-2x fa-angle-left"></i>
                </a>
            @else
                <a class="btn btn-white text-primary" href="{{$paginator->previousPageUrl()}}">
                    <i class="fa fa-2x fa-angle-left"></i>
                </a>              
            @endif       
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="btn btn-white text-primary" href="{{$paginator->nextPageUrl()}}">
                    <i class="fa fa-2x fa-angle-right"></i>
                </a> 
            @else
                <a class="btn disabled">
                    <i class="fa fa-2x fa-angle-right"></i>
                </a> 
            @endif 
        
        </ul>
    </nav>
@endif
