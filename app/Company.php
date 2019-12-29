<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Str;

class Company extends Model
{
    // Only need this fillable if we are doing PartyController counter as 
    // $viewCount = $company->view_count + 1;
    // $company->update(['view_count' => $viewCount]);
    //protected $fillable = ['view_count'];
    //protected $dates = ['published_at'];
    use SoftDeletes;
    protected $fillable = ['title', 'slug', 'description', 'category_id', 'image'];

	public function user() {
		return $this->belongsTo(User::class);
	}

    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the Company tags.
     *
     * @return array
     */
    public function tags()
    {
        // Many To Many Relation
        // Does not use save or create, belongsToMany uses attach
        return $this->belongsToMany(Tag::class); //'App\Tag'
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsNumber($label = 'Comment')
    {
        $commentsNumber = $this->comments->count();

        return $commentsNumber . " " . Str::plural($label, $commentsNumber);
    }

    public function createComment(array $data)
    {
        $this->comments()->create($data);
    }

    public function createTags($tagString)
    {
        $tags = explode(",", $tagString);
        $tagIds = [];

/*        foreach ($tags as $tag) 
        {        
            //$newTag = new Tag();
            // The first array is the search criteria. While the second array is the model attribute. If the record was not found, the first and second arrays will be merged which will be used as the model attributes.
            $newTag = Tag::firstOrCreate(
                ['slug' => str_slug($tag)], ['name' => trim($tag)]
            );

            //$newTag->name = ucwords(trim($tag));
            //$newTag->slug = str_slug($tag);
            $newTag->save();  

            $tagIds[] = $newTag->id;
        }

        $this->tags()->detach();
        $this->tags()->attach($tagIds);*/


        foreach ($tags as $tag)
        {
            $newTag = Tag::firstOrCreate([
                'slug' => str_slug($tag),
                'name' => ucwords(trim($tag))
            ]);

            $tagIds[] = $newTag->id;
        }

        $this->tags()->sync($tagIds);
    }

    public function getTagsListAttribute()
    {
        return $this->tags->pluck('name');
    }

    public function getImageUrlAttribute($value) {
    	$imageUrl = "";

    	if(!is_null($this->image)){
            $directory = config('cms.image.directory');
    		$imagePath = public_path(). "/{$directory}/" . $this->image;
    		if (file_exists($imagePath)) $imageUrl = asset("{$directory}/". $this->image);
    	}

    	return $imageUrl;
    }

    public function getImageThumbUrlAttribute($value) {
        $imageUrl = "";


        if(!is_null($this->image)){
            $directory = config('cms.image.directory');
            $ext = substr(strrchr($this->image, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $this->image);
            $imagePath = public_path(). "/{$directory}/" . $thumbnail;
            if (file_exists($imagePath)) $imageUrl = asset("{$directory}/". $thumbnail);
        }

        return $imageUrl;
    }
    // We can use setters to change the value before being submitted    
/*    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ?: NULL;
    }*/


    public function getDateAttribute($value) {
    	return $this->created_at->diffForHumans();
    }

    public function getDescriptionHtmlAttribute($value){
    	// escape is e
    	return $this->description ? Markdown::convertToHtml(e($this->description)) : null;
    }

    public function getTagsHtmlAttribute()
    {
        $anchors = [];
        foreach($this->tags as $tag) {
            $anchors[] = '<a href="' . route('tag', $tag->slug) . '">' . $tag->name . '</a>';
        }
        return implode(", ", $anchors);
    }

    public function dateFormatted($showTimes = false)
    {
        $format = "d/m/Y";
        if ($showTimes) $format = $format . " H:i:s";
        return $this->created_at->format($format);
    }

    public function approvedLabel()
    {
        if ( ! $this->approved) {
            return '<span class="label label-warning">Pending</span>';
        }
        else {
            return '<span class="label label-success">Approved</span>';
        }
    }

    public function scopeLatestFirst($query) {
    	return $query->orderBy('created_at', 'desc');
    }

    public function scopePopular($query) {
        return $query->orderBy('view_count', 'desc');
    }

    public function scopeApproved($query) {
    	return $query->where('approved', '=', true);
    }

    public function scopeFilter($query, $filter)
    {
        if (isset($filter['month']) && $month = $filter['month']) {
            $date = date_parse('July');
            // whereRaw since we are just checking the month
            $query->whereRaw('month(created_at) = ?', [$date['month']]);
            // laravel >= 5.3 whereMonth('created_at', $month);
        }

        if (isset($filter['year']) && $year = $filter['year']) {
            $query->whereRaw('year(created_at) = ?', [$year]);
            // laravel >= 5.3 whereYear('created_at', $year);
        }

        // check if any term entered
        if (isset($filter['term']) && $term = $filter['term'])
        {
            $query->where(function($q) use ($term) {
                // $q->whereHas('author', function($qr) use ($term) {
                //     $qr->where('name', 'LIKE', "%{$term}%");
                // });
                // $q->orWhereHas('category', function($qr) use ($term) {
                //     $qr->where('title', 'LIKE', "%{$term}%");
                // });
                $q->orWhere('title', 'LIKE', "%{$term}%");
                $q->orWhere('description', 'LIKE', "%{$term}%");
            });
        }
    }

    public static function archives()
    {
        return static::selectRaw('count(id) as company_count, year(created_at) year, monthname(created_at) month')
                        ->approved()
                        ->groupBy('year', 'month')
                        ->orderByRaw('min(created_at) desc')
                        ->get();
    }
}
