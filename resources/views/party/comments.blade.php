<article class="post-comments" id="post-comments">
    <h3><i class="fa fa-comments"></i> {{ $company->commentsNumber('Comment') }}</h3>

    <div class="comment-body padding-10">
        <ul class="comments-list">

            @foreach($companyComments as $comment)
                <li class="comment-item">
                    <div class="comment-heading clearfix">
                        <div class="comment-author-meta">
                            <h4>{{ $comment->user->name }} <small>{{ $comment->date }}<!-- accessor --></small></h4>
                        </div>
                    </div>
                    <div class="comment-content">
                        <!-- accessor -->
                        {!! $comment->comment_html !!}
                    </div>
                </li>
            @endforeach
        </ul>
            <nav>
                {!! $companyComments->links() !!}
                <!-- had $companies->links() until we had to use the search term -->

            </nav>

        <ul>
            <li class="comment-item" style="display:none;">
                <div class="comment-heading clearfix">
                    <div class="comment-author-meta">
                        <h4>John Doe <small>January 14, 2016</small></h4>
                    </div>
                </div>
                <div class="comment-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nesciunt nulla est, atque ratione nostrum cumque ducimus maxime, amet enim tempore ipsam. Id ea, veniam ipsam perspiciatis assumenda magnam doloribus!</p>
                    <p>Quibusdam iusto culpa, necessitatibus, libero sequi quae commodi ea ab non facilis enim vitae inventore laborum hic unde esse debitis. Adipisci nostrum reprehenderit explicabo, non molestias aliquid quibusdam tempore. Vel.</p>
                </div>
            </li>

            <li class="comment-item" style="display:none;">
                <div class="comment-heading clearfix">
                    <div class="comment-author-meta">
                        <h4>John Doe <small>January 14, 2016</small></h4>
                    </div>
                </div>
                <div class="comment-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nesciunt nulla est, atque ratione nostrum cumque ducimus maxime, amet enim tempore ipsam. Id ea, veniam ipsam perspiciatis assumenda magnam doloribus!</p>
                    <p>Quibusdam iusto culpa, necessitatibus, libero sequi quae commodi ea ab non facilis enim vitae inventore laborum hic unde esse debitis. Adipisci nostrum reprehenderit explicabo, non molestias aliquid quibusdam tempore. Vel.</p>

                    <ul class="comments-list-children">
                        <li class="comment-item">
                            <div class="comment-heading clearfix">
                                <div class="comment-author-meta">
                                    <h4>John Doe <small>January 14, 2016</small></h4>
                                </div>
                            </div>
                            <div class="comment-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nesciunt nulla est, atque ratione nostrum cumque ducimus maxime, amet enim tempore ipsam. Id ea, veniam ipsam perspiciatis assumenda magnam doloribus!</p>
                                <p>Quibusdam iusto culpa, necessitatibus, libero sequi quae commodi ea ab non facilis enim vitae inventore laborum hic unde esse debitis. Adipisci nostrum reprehenderit explicabo, non molestias aliquid quibusdam tempore. Vel.</p>
                            </div>
                        </li>

                        <li class="comment-item">
                            <div class="comment-heading clearfix">
                                <div class="comment-author-meta">
                                    <h4>John Doe <small>January 14, 2016</small></h4>
                                </div>
                            </div>
                            <div class="comment-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nesciunt nulla est, atque ratione nostrum cumque ducimus maxime, amet enim tempore ipsam. Id ea, veniam ipsam perspiciatis assumenda magnam doloribus!</p>
                                <p>Quibusdam iusto culpa, necessitatibus, libero sequi quae commodi ea ab non facilis enim vitae inventore laborum hic unde esse debitis. Adipisci nostrum reprehenderit explicabo, non molestias aliquid quibusdam tempore. Vel.</p>

                                <ul class="comments-list-children">
                                    <li class="comment-item">
                                        <div class="comment-heading clearfix">
                                            <div class="comment-author-meta">
                                                <h4>John Doe <small>January 14, 2016</small></h4>
                                            </div>
                                        </div>
                                        <div class="comment-content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nesciunt nulla est, atque ratione nostrum cumque ducimus maxime, amet enim tempore ipsam. Id ea, veniam ipsam perspiciatis assumenda magnam doloribus!</p>
                                            <p>Quibusdam iusto culpa, necessitatibus, libero sequi quae commodi ea ab non facilis enim vitae inventore laborum hic unde esse debitis. Adipisci nostrum reprehenderit explicabo, non molestias aliquid quibusdam tempore. Vel.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>
            <div class="form-group required" style="display:none;">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group required" style="display:none;">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>
            <div class="form-group" style="display:none;">
                <label for="website">Website</label>
                <input type="text" name="website" id="website" class="form-control">
            </div>
    <div class="comment-footer padding-10">
        <h3>Leave a comment</h3>
        
        @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('party.comments', $company->slug) }}">
            @csrf
            <div class="form-group required{{ $errors->has('comment') ? ' has-error' : '' }}">
                <label for="comment">{{ __('Comment') }}</label>
                <textarea name="comment" id="comment" rows="6" class="form-control">{{ old('comment') }}</textarea>
                @if ($errors->has('comment'))
                    <span class="help-block" role="alert">
                        <strong>{{ $errors->first('comment') }}</strong>
                    </span>
                @endif
            </div>
            <div class="clearfix">
                <div class="pull-left">
                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>
                <div class="pull-right">
                    <p class="text-muted">
                        <span class="required">*</span>
                        <em>Indicates required fields</em>
                    </p>
                </div>
            </div>
        </form>
    </div>

</article>
