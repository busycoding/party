@extends('layouts.main')

@section('content')
<?php $user = $company->user; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post-item post-detail">
                    @if ($company->image_url)
                      <div class="post-item-image">
                          <img src="{{ $company->image_url }}" alt="{{ $company->title }}">
                      </div>
                    @endif

                    <div class="post-item-body">
                        <div class="padding-10">
                            <h1>{{ $company->title }}</h1>

                            <div class="post-meta no-border">
                                <ul class="post-meta-group">
                                    <li><i class="fa fa-user"></i><a href="{{ route('user', $user->slug) }}"> {{ $user->name }}</a></li>
                                    <li><i class="fa fa-clock-o"></i><time> {{ $company->date }}</time></li>
                                    <li><i class="fa fa-folder"></i><a href="{{ route('category', $company->category->slug )}}"> {{ $company->category->title }}</a></li>
                                    <li><i class="fa fa-tag"></i>{!! $company->tags_html !!}</li>
                                    <li><i class="fa fa-comments"></i><a href="#post-comments">{{ $company->commentsNumber() }}</a></li>
                                </ul>
                            </div>
                            <!-- escape is e, we used to have Markdown::convertToHtml(e($company->description)) -->
                            {!! $company->description_html !!}
                        </div>
                    </div>
                </article>

                <article class="post-author padding-10">
                    <div class="media">
                      <div class="media-left">

                        <a href="{{ route('user', $user->slug) }}">
                          <img alt="{{ $user->name }}" width="100" height="100" src="{{ $user->gravatar() }}" class="media-object">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="{{ route('user', $user->slug) }}">{{ $user->name }}</a></h4>
                        <div class="post-author-count">
                          <a href="{{ route('user', $user->slug) }}">
                              <i class="fa fa-clone"></i>
                              <?php $companyCountOld = $user->companies->count() ?>
                              <?php $companyCount = $user->companies()->approved()->count() ?>
                              {{ $companyCount }} {{ \Illuminate\Support\Str::plural('companies', $companyCount) }}
                          </a>
                        </div>
                        {!! $user->bio_html !!}
                      </div>
                    </div>
                </article>

                @include('party.comments')
            </div>

            @include('layouts.sidebar')
        </div>
    </div>

@endsection
