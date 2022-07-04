<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommunicationRequest;
use App\Http\Requests\UpdateCommunicationRequest;
use App\Models\Communication;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\CommunicationResource;

class CommunicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request -> user() -> type == 'cse'){
            return CommunicationResource::collection(Communication::paginate());
        }else{
            return CommunicationResource::collection(Communication::where('user_id', $request->user()->id)->paginate());
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommunicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommunicationRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $request -> user() -> id;
        $question_id = $request['question_id'];
        
        $communication = Communication::create($data);

        $question = Question::updateOrCreate([
            'id' => $question_id,
        ], 
        [
            'status' => "In Progress",
        ]);
        return $communication;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Communication $communication)
    {
        if ($request -> user() -> type == 'cse'){
            return $communication;
        }else{
            if ($request -> user() -> id != $communication->user_id){
                return abort(403, 'Unauthorized');
            }
            return $communication;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommunicationRequest  $request
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommunicationRequest $request, Communication $communication)
    {
        $communication->update($request->all());
        return $communication;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Communication  $communication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Communication $communication)
    {
        $communication->delete();
        return response('', 204 );
    }
}
