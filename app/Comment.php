<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'comment', 'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getCommentHtmlAttribute()
    {
        return Markdown::convertToHtml(e($this->comment));
    }
}
