<?php

namespace App\Models;

use Markdown;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experience';
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];


    /**
     * Set the HTML content automatically when the raw content is set
     *
     * @param string $value
     */
    public function setContentRawAttribute($value)
    {
        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = Markdown::convertToHtml($value);
    }

    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = str_replace('fa-','am-icon-',$value);
    }

    /**
     * Alias for content_raw
     */
    public function getContentAttribute($value)
    {
        return $this->content_raw;
    }

    public function getIconAttribute($value)
    {
        $fa_icon = str_replace('am-icon-','fa-',$value);
        $am_icon = $value;
        return array($fa_icon,$am_icon);
    }
}
