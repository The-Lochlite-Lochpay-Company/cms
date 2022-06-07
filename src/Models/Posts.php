<?php
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

namespace lochlite\cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use lochlite\cms\Models\Postsbody;
use lochlite\cms\Models\Postvoters;
use lochlite\cms\Models\Comments;
use lochlite\cms\Models\Commentsreply;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Auth;

class Posts extends Model implements Feedable, Sitemapable
{
    use HasFactory;
    use HasSlug;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'authors', 'category', 'keywords', 'description', 'imgcap', 'url', 'upvote', 'downvote', 'views', 'status'];	

    /**
     * Get the content of the post.
     */
    public function body()
    {
        return $this->hasMany(Postsbody::class, 'post_id', 'id')->first();
    }

    /**
     * Get the content of the post.
     */
    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id', 'id')->with('reply')->get();
    }

    /**
     * Get the content of the post.
     */
    public function commentsApproved()
    {
        return $this->hasMany(Comments::class, 'post_id', 'id')->where('status', 'approved')->with('reply')->get();
    }

    /**
     * Get the content of the post.
     */
    public function commentsLatest()
    {
        return $this->hasMany(Comments::class, 'post_id', 'id')->latest()->with('reply')->get();
    }

    /**
     * Get the content of the post.
     */
    public function commented($data)
    {
        return Comments::create(['post_id' => $this->id, 'user_id' => Auth()->user()->id, 'name' => Auth()->user()->name, 'email' => Auth()->user()->email, 'avatar' => Auth()->user()->avatar, 'comment' => $data]);
    }

    /**
     * Get the content of the post.
     */
    public function voters()
    {
        return $this->hasMany(Postvoters::class, 'post_id', 'id');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('url')
			->usingLanguage('pt')
            ->doNotGenerateSlugsOnUpdate()
            ->preventOverwrite();
    }
	
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($this->updated_at)
            ->link('/blog/'. $this->url)
            ->category($this->category)
            ->authorName($this->authors);
    }

    public static function getFeedItems()
    {
       return Posts::all();
    }	

    public function toSitemapTag(): Url | string | array
    {
        return route('blog.post.show', $this);
    }
	 
}
