<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Request;
use App\Article;
use App\Http\Resources\Article as ArticleResource;

use App\WeightRecord;
use App\Http\Resources\WeightRecord as WeightRecordResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }

    public function index_sleep()
    {
        // Get articles
        $sleepRecords = SleepRecord::orderBy('created_at', 'desc')->paginate(5);

        // Return collection of articles as a resource
        return SleepRecordResource::collection($sleepRecords);
    }


    public function index_weight()
    {
        // Get articles
        $weightRecords = WeightRecord::orderBy('date', 'desc')->paginate(10);

        // Return collection of articles as a resource
        return WeightRecordResource::collection($weightRecords);
    }
    /*
    public function index_weightNoId()
    {
        // Get articles
        $weightRecords = WeightRecord::orderBy('date', 'desc')->pluck('date','weight');

        // Return collection of articles as a resource
        return WeightRecordResource::collection($weightRecords);
    }
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');   
        
        if($article->save()){
            return new ArticleResource($article);
        }
    }

    public function store_weightRecord1(Request $request)
    {

        $weightRecord = $request->isMethod('put') ? WeightRecord::findOrFail($request->weightRecord_id) : new WeightRecord;

        $weightRecord->id = $request->input('weightRecord_id');
        $weightRecord->weight = $request->input('weight');
        $weightRecord->date = $request->input('date');   
        
        if($weightRecord->save()){
            return new WeightRecordResource($weightRecord);
        }
    }

    public function store_excerciseRecord(Request $request)
    {

        $excerciseRecord = $request->isMethod('put') ? ExcerciseRecord::findOrFail($request->excerciseRecord_id) : new ExcerciseRecord;

        $excerciseRecord->id = $request->input('excerciseRecord_id');
        $excerciseRecord->date = $request->input('date');
        $excerciseRecord->exercise = $request->input('exercise');   
        $excerciseRecord->repetitions = $request->input('repetitions');   
        $excerciseRecord->weight = $request->input('weight');   

        
        if($excerciseRecord->save()){
            return new ExcerciseRecordResource($excerciseRecord);
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return new ArticleResource($article);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if($article->delete()){
            return new ArticleResource($article);
        }
       
    }
}
