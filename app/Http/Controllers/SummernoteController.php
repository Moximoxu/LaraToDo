<?php

namespace LaraToDo\Http\Controllers;

use LaraToDo\Summernote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SummernoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Summernote::get();
        return View::make('editor', ['contents' => $contents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detail=$request->summernoteInput;
 
        $dom = new \domdocument();
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');
 
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
 
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
 
            $data = base64_decode($data);
            $image_name= time().$k.'.png';
            $path = public_path() .'/'. $image_name;
 
            file_put_contents($path, $data);
 
            $img->removeattribute('src');
            $img->setattribute('src', $image_name);
        }
 
        $detail = $dom->savehtml();
        $summernote = new Summernote;
        $summernote->content = $detail;
        $summernote->save();

        return View::make('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $contents = Summernote::get();
        return View::make('summernote', ['contents' => $contents]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function get(Summernote $summernote)
    {
        $summernote_content = $summernote->content;
        return View::make('summernote', ['summernote_content' => $summernote_content]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function edit(Summernote $summernote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Summernote $summernote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Summernote $summernote)
    {
        //
    }
}
