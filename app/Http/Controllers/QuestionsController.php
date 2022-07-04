<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\Communication;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\CommunicationResource;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request -> user() -> type == 'cse'){
            return QuestionResource::collection(Question::paginate());
        }
        return QuestionResource::collection(Question::where('user_id', $request->user()->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $request -> user() -> id;
        $data['status'] = 'Not Answered';
        $question = Question::create($data);
        return $question;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Question $question)
    {   
        if ($request -> user() -> type == 'cse'){
            $data=[];
            $data['question']=$question;
            $communication = Communication::where( 'question_id', $question->id )->get();
            $data['communication'] = $communication;
            return $data;
        }
        if ($request -> user() -> id != $question->user_id){
            return abort(403, 'Unauthorized');
        }
        $data=[];
        $data['question']=$question;
        $communication = Communication::where( 'question_id', $question->id )->get();
        $data['communication'] = $communication;
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuestionRequest  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        if ($request -> user() -> type == 'cse'){
            $question->update($request->all());
            return $question;
        }else{
            if ($request -> user() -> id != $question->user_id){
                return abort(403, 'Unauthorized');
            }
            $question->update($request->all());
            return $question;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Question $question)
    {
        if ($request -> user() -> id != $question->user_id){
            return abort(403, 'Unauthorized');
        }
        $question->delete();
        return response('', 204 );
    }
}
