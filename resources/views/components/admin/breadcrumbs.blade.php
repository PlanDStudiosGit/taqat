<div class="col-md-6">
    <div class="title">
          <span>
            <h2> <span class="mob"><img class="img-fluid" src="{{ asset('img/menu.svg') }} " alt=""></span>
            <span class="menuwidth"><img class="img-fluid" src="{{ asset('img/menu.svg') }} " alt=""></span> {{ $pageName }} </h2>

            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  @foreach ($breadCrumbs as $breadCrumb)
                    <li class="breadcrumb-item {{ $breadCrumb->class }}"><a href="{{ $breadCrumb->url }}">{{ $breadCrumb->name }}</a></li>
                  @endforeach
              </ol>
            </nav>
          </span>
    </div>
</div>
