<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Request;
use App\Article;
use App\Http\Resources\Article as ArticleResource;

use App\WeightRecord;
use App\Http\Resources\WeightRecord as WeightRecordResource;

use App\Exercise;
use App\Http\Resources\Exercise as ExerciseRecordResource;

use Illuminate\Support\Facades\DB;

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


    public function index_exerciseRecords()
    {
        // Get articles
        $exerciseRecords = Exercise::orderBy('date', 'desc');
        $exerciseRecords = $exerciseRecords->paginate(10);

        // Return collection of articles as a resource
        return ExerciseRecordResource::collection( $exerciseRecords );
    }


    public function index_latestSpecificExerciseRecords()
    {
        // Get articles
        //$exerciseRecords = Exercise::where('exercise','back row');
        //$exerciseRecords = DB::table('exercises')->where('exercise','pull up');
        //$exerciseRecords = Exercise::orderBy('date', 'asc')->where('exercise','pull up');
        //$exerciseRecords = Exercise::orderBy('date', 'desc')->paginate(10);
        //$exerciseRecords = Exercise::orderBy('date', 'desc')->where('repetitions', '8');      
        //$product = $exerciseRecords->>where('exercise','pull up')->first();
        // return $exerciseRecords;
        // Return collection of articles as a resource

        //$exerciseRecords = Exercise::orderBy('date', 'desc')->paginate(10);
        //return ExerciseRecordResource::collection($exerciseRecords);

        $exerciseRecords = Exercise::all()->where('exercise','pull up');

        //$specific = )->where('name', 'John')
        return ExerciseRecordResource::collection($exerciseRecords);


    }

    public function index_latestSpecificExerciseRecordsWithExercise($id)
    {
        // Get articles
        //$exerciseRecords = Exercise::where('exercise','back row');
        //$exerciseRecords = DB::table('exercises')->where('exercise','pull up');
        //$exerciseRecords = Exercise::orderBy('date', 'asc')->where('exercise','pull up');
        //$exerciseRecords = Exercise::orderBy('date', 'desc')->paginate(10);
        //$exerciseRecords = Exercise::orderBy('date', 'desc')->where('repetitions', '8');      
        //$product = $exerciseRecords->>where('exercise','pull up')->first();
        // return $exerciseRecords;
        // Return collection of articles as a resource

        //$exerciseRecords = Exercise::orderBy('date', 'desc')->paginate(10);
        //return ExerciseRecordResource::collection($exerciseRecords);

        $exerciseRecords = Exercise::all()->where('exercise',$id);

        //$specific = )->where('name', 'John')
        return ExerciseRecordResource::collection($exerciseRecords);


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

    public function store_exerciseRecord(Request $request)
    {

        $exerciseRecord = $request->isMethod('put') ? Exercise::findOrFail($request->exerciseRecord_id) : new Exercise;

        $exerciseRecord->id = $request->input('exerciseRecord_id');
        $exerciseRecord->date = $request->input('date');
        $exerciseRecord->exercise = $request->input('exercise');   
        $exerciseRecord->repetitions = $request->input('repetitions');   
        $exerciseRecord->weight = $request->input('weight');   

        
        if($exerciseRecord->save()){
            return new ExerciseRecordResource($exerciseRecord);
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

    public function show_showSpecificExercise(Request $request)
    {
        $ids = $request->all();
        //dd($ids[0]);

        $value = $ids[0];

        //$data = collect(json_decode($request));
        //dd($data);


        // works aswell
        //$exerciseRecords = Exercise::all()->where('exercise', $value);
        $exerciseRecords = Exercise::orderBy('date', 'desc')->where('exercise', $value)->get();




        //$specific = )->where('name', 'John')
        return ExerciseRecordResource::collection($exerciseRecords);
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
