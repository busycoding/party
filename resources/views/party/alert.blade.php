@if (isset($categoryName))
    <div class="alert alert-info">
        <p>Category: <strong>{{ $categoryName }}</strong></p>
    </div>
@endif

@if (isset($tagName))
    <div class="alert alert-info">
        <p>Tagged: <strong>{{ $tagName }}</strong></p>
    </div>
@endif

@if (isset($userName))
    <div class="alert alert-info">
        <p>Author: <strong>{{ $userName }}</strong></p>
    </div>
@endif

@if ($term = request('term'))
    <div class="alert alert-info">
        <p>Search Results for: <strong>{{ $term }}</strong></p>
    </div>
@endif