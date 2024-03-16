<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Feeds;
use Illuminate\Support\Facades\Redirect;

class XmlController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('main', ['feeds' => Feeds::all()->sortByDesc('created_at')]);
    }

    public function createFeedUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ], ['url.required' => 'Поле URL обязательно для заполнения']);

        $url = $request->url;

        $urlExists = Feeds::where('url', $url)->exists();

        if ($urlExists) {

            session()->flash('message', 'URL уже существует');
            return Redirect::route('main');

        } else {

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {

                Feeds::create(['url' => $url]);
                session()->flash('message', 'URL успешно добавлен!');

                return Redirect::route('main');

            } else {

                return Redirect::back()
                    ->withErrors(['error' => 'URL не существует']);
            }
        }
    }
}
