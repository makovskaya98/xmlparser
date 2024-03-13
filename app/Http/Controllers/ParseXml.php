<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ParseXml extends Controller
{
    public function parseXml(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
        ]);

        $url = $request->url;
        $xml = $this->getXml($url);

        /*$categories = $xml->shop->categories->category;
        foreach ($categories as $category) {
            print_r($category);
            print_R('<br/>');
        }*/

        $offers = $xml->shop->offers->offer;
        foreach ($offers as $offer) {
            print_r($offer);
            print_R('<br/>');
        }


    }
}
