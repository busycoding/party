            <div class="col-md-4">
                <aside class="right-sidebar">
                    <div class="search-widget">
                        <form action="{{ route('company') }}">
                            <div class="input-group">
                                <input type="text" class="form-control input-lg" value="{{ request('term') }}" name="term" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-lg btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                              </span>
                            </div><!-- /input-group -->
                        </form>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <h4>Categories</h4>
                        </div>
                        <div class="widget-body">
                            <ul class="categories">
                                @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('category', $category->slug) }}"><i class="fa fa-angle-right"></i> {{ $category->title }}</a>
                                    <span class="badge badge-secondary pull-right">{{ $category->companies->count() }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <h4>Popular Companies</h4>
                        </div>
                        <div class="widget-body">
                            <ul class="popular-posts">
                                @foreach ($popularCompanies as $company)
                                    <li>
                                        @if ($company->image_thumb_url)
                                            <div class="post-image">
                                                <a href="{{ route('party.show', $company->slug) }}">
                                                    <img src="{{ $company->image_thumb_url }}" />
                                                </a>
                                            </div>
                                        @endif
                                        <div class="post-body">
                                            <h6><a href="{{ route('party.show', $company->slug) }}">{{ $company->title }}</a></h6>
                                            <div class="post-meta">
                                                <span>{{ $company->date }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <h4>Tags</h4>
                        </div>
                        <div class="widget-body">
                            <ul class="tags">
                                @foreach($tags as $tag)
                                    <li><a href="{{ route('tag', $tag->slug) }}">{{ $tag->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="widget">
                        <div class="widget-heading">
                            <h4>Archives</h4>
                        </div>
                        <div class="widget-body">
                            <ul class="categories">
                                @foreach($archives as $archive)
                                    <li>
                                        <a href="{{ route('company', ['month' => $archive->month, 'year' => $archive->year]) }}">{{ $archive->month . " " . $archive->year }}</a>
                                        <span class="badge badge-secondary pull-right">{{ $archive->company_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>