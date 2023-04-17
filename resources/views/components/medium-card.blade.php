<a href="{{$link??'#'}}">
    <div class="card text-white bg-{{$class??'success'}} mb-3 stats">
          <div class="card-header text-center">
            <span><h4>{{$title??'No title'}}</h4></span>
          </div>
          <div class="card-body">
            <h2 class="card-title text-center"><?= $value??'no value'; ?></h2>
          </div>
    </div>
</a>