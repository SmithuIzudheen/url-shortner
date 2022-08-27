<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlRequest;
use App\DataTables\ShortUrlDataTable;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ShortUrl;
use DataTables;


class ShortUrlController extends Controller
{
    
    /**
     * For listing the short urls
     *
     * @param Builder $builder
     * @return void
    */


    public function index(Builder $builder, ShortUrlDataTable $dataTable)
    {
        return $dataTable->render('short_url.index');
    }


    /**
     * For creating the short url and to store in database
     *
     * @param ShortUrlRequest $request
     * @return void
     */
    public function store(ShortUrlRequest $request)
    {
        $short_url = new ShortUrl;
        $short_url->uuid = Str::uuid();
        $short_url->url = $request->url;
        $short_url->short_url = substr(md5(uniqid(rand(), true)),0,6);
        $short_url->save();

        return redirect()->route('short-url.index')->with('toastr', ['type'=>'success','text'=>'Short url generated successfully.',]);
    }


    /**
     * For deleting the url
     *
     * @param UUID
     * @return void
     */
    public function destroy($uuid)
    {
        $short_url = ShortUrl::where('uuid',$uuid)->delete();
        
        return true;
    }

    /**
     * For redirecting the short url to original url
     *
     * @param short_url
     * @return void
     */
    public function redirect($short_url)
    {
        $short_url = ShortUrl::where('short_url',$short_url)->first();
        $short_url->visitors = $short_url->visitors+1;
        $short_url->save();
        
        if($short_url != null)
            return redirect($short_url->url);
        else
            return redirect('/');
    }

}
