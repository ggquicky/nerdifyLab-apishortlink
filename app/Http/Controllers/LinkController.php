<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkCollection;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Models\LinkCounter;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function index()
    {
        $link = Link::query()->with('user')
            ->where('user_id',Auth::id())->orderBy('created_at')->get();
        $link->load('user', 'linkcounters');
        return new LinkCollection($link);
    }

    public function show()
    {

    }
    public function update(Request $request, Link $link)
    {
        $data = $request->validate([
            'url' => ['required', 'url']

        ]);
        $link->update($data);
        $link->load('user', 'linkcounters');
//        return LinkResource::make($link);
        return LinkResource::make($link);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'url' => 'required|url',
//            'user_id' => 'required'
        ]);

        $data['laravel_url'] = Str::random(4);
        $data['user_id'] = Auth::id();

        $link = Link::create($data)->fresh();

        $link->load('user','linkcounters');

        return new LinkResource($link);
    }

    public function find(string $laravel_url)
    {
        $find = Link::where('laravel_url', $laravel_url)->first();

        $click = [
            'link_id' => $find->id,
        ];
        LinkCounter::create($click);

        return redirect($find->url);
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return response('',status: Response::HTTP_NO_CONTENT);
    }
}
