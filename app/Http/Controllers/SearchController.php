<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\Communication;

class SearchController extends Controller
{
    public function searchByName(Request $request, $name) {
        if ($request->user()->type != 'cse'){
            return abort(403, 'Unauthorized');
        }
        $user = User::where( 'name' , $name )->get();
        if (count($user) <= 0 ){
            return abort(404, 'Not Found');
        }else{
            return $user;
            $data=[];
            $question=Question::where( 'user_id', $user[0]->id )->get();
            $data['question']=$question;
            return $data;
        }
     }
     public function searchByStatus(Request $request, $status) {
        if ($request->user()->type != 'cse'){
            return abort(403, 'Unauthorized');
        }
        $data=[];
        $question=Question::where( 'status', $status )->get();
        $data['question']=$question;
        return $data;
     }
}
