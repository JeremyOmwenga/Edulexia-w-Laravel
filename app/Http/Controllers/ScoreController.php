<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;

class ScoreController extends Controller
{
    //
    public function playgame1(){
    	return view('game1');
    }
    public function storegame1score(Request $request){
    	$data = $request->validate([
    		'score1' =>'required|numeric'
    	]);

    	$newScore = Score::create($data);

    	return redirect(route('dashboard'));
    }
}
