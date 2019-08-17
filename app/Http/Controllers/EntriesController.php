<?php

namespace App\Http\Controllers;

use App\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntriesController extends Controller
{
    public function store(Request $request){
        Entry::create([
            'body'=> $request->body,
            'entry_user_name'=> Auth::user()->name,
            'user_id' => Auth::id()
        ]);

        return 'Entry Added Successfully';

    }
    public function getUserEntries(){
        return 'dave';
    }

}
