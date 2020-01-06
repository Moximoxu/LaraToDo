<?php

namespace LaraToDo\Http\Controllers;

use LaraToDo\Summernote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use DOMDocument;

class SummernoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $summernotes = Summernote::get();
        return View::make('countimer/editor', ['summernotes' => $summernotes]);
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
        $detail = $request->summernoteInput;

        $dom = new \DOMDocument();
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

        $summernotes = Summernote::get();
        return View::make('countimer/editor', ['summernotes' => $summernotes]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function get(Summernote $summernote)
    {
        return View::make('countimer/summernote', ['summernote' => $summernote]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function edit(Summernote $summernote)
    {
        $summernote_id = $summernote->id;
        return View::make('countimer/editor', ['summernote_content' => $summernote->content, 'summernote_id' => $summernote_id]);
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
        $detail=$request->summernoteUpdate;

        $dom = new \DOMDocument();
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

        $content_id = $request->get('content_id');
        $detail = $dom->savehtml();

        Summernote::updateOrInsert(
            ['id' => $content_id],
            ['content' => $detail,
            'updated_at' => Carbon::now()]
        );

        $summernotes = Summernote::get();
        return View::make('countimer/editor', ['summernotes' => $summernotes]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \LaraToDo\Summernote  $summernote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Summernote $summernote)
    {
        $summernote->delete();
    }
}
