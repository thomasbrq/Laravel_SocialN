<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function shortenLink($id)
        {
            $website = Post::all();

            $regex = '(http://www.|https://www.|http://|https://)';
            $url = $website[$id]->website_url;
            $length = strlen($url);
            if($length > 30)
            {
                $url = preg_replace($regex, '', $url);
                $pos = strpos($url, '/')+1;
                $url = str_split($url);
                $url = array_reverse($url);
                $url = array_splice($url, -($pos+10));
                $url = array_reverse($url);
                $url = implode($url);
                $url = $url.'...';
            }
            return $url;
        }
        
}
