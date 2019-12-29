@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php Auth::user() ? $currentUser = Auth::user() : $currentUser = '' ?>
                @if ($currentUser)
                {{ $currentUser->name }}
                @endif
                @if (! $companies->count())
                    <div class="alert alert-warning">
                        <p>Nothing Found</p>
                    </div>
                @else
                    @include('party.alert')

                    @foreach($companies as $company)
                        <article class="post-item">
                            @if ($company->image_url)
                            <div class="post-item-image">
                                <a href="{{ route('party.show', $company->slug) }}">
                                    <!-- removed img/{{$company->image}} --> 
                                    <img src="{{$company->image_url}}" alt="">
                                </a>
                            </div>
                            @endif
                            <div class="post-item-body">
                                <div class="padding-10">
                                    <h2><a href="{{ route('party.show', $company->slug) }}">{{$company->title}}</a></h2>
                                    <p>{!! $company->description_html !!}</p>
                                </div>

                                <div class="post-meta padding-10 clearfix">
                                    <div class="pull-left">
                                        <ul class="post-meta-group">
                                            <li>
                                                @if(!empty($company->user->slug))
                                                    <i class="fa fa-user"></i><a href="{{ route('user', $company->user->slug) }}"> {{ $company->user->name }}</a>
                                                @else
                                                    <i class="fa fa-user"></i> {{ $company->user->name }}
                                                @endif
                                            </li>
                                            <li><i class="fa fa-clock-o"></i><time> <span style="display:none;">{{$company->created_at->diffForHumans()}}</span>{{ $company->date }}</time></li>
                                            <li><i class="fa fa-tags"></i><a href="{{ route('category', $company->category->slug) }}"> {{ $company->category->title }}</a></li>
                                            <!-- Company model getTagsHtmlAttribute -->
                                            <li><i class="fa fa-tag"></i>{!! $company->tags_html !!}</li>
                                            <li><i class="fa fa-comments"></i><a href="{{ route('party.show', $company->slug) }}#post-comments">{{ $company->commentsNumber() }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('party.show', $company->slug) }}">Continue Reading &raquo;</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endif
                <nav>
                  <!-- had $companies->links() until we had to use the search term -->
                  {{ $companies->appends(request()->only(['term', 'month', 'year']))->links() }}
                </nav>

            </div>
            @include('layouts.sidebar')
        </div>
    </div>

@endsection