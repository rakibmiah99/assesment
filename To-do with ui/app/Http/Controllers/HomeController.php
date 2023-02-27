<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\ListModel;

class HomeController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::id();
            $this->lists = ListModel::where('user_id','=', $this->user_id);
            return $next($request);
        });
    }

    function Page(Request $request){
        $number_of_view = 10;
        $lists = $this->lists->paginate($number_of_view);
        return view('HomePages.List', compact('lists', 'number_of_view'));
    }

    function Create(Request $request){
        return view('HomePages.Create');
    }

    function Store(Request $request){
        $credential = $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'nullable'
        ]);

        if ($credential){
            $credential['user_id'] =  $this->user_id;
            if(ListModel::insert($credential)){
                return redirect()->back()->with('success', 'inserted successfully');
            }
            else{
                return redirect()->back()->withErrors([
                    'server_error' => 'Something went wrong try again'
                ])->withInput();
            }
        }
    }


    function Edit($id){
        $id = Crypt::decrypt($id);
        $data = $this->lists->find($id);
        return view('HomePages.Update', compact('data'));
    }

    function Update(Request $request, $id){
        $id = Crypt::decrypt($id);
        $credential = $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'nullable'
        ]);

        if ($credential){
            if($this->lists->where('id', '=', $id)->update($credential)){
                return redirect()->back()->with('success', 'updated successfully');
            }
            else{
                return redirect()->back()->withErrors([
                    'server_error' => 'Something went wrong try again'
                ])->withInput();
            }
        }
    }

    function Delete($id){
        return view('HomePages.Delete', compact('id'));
    }
    function Deleted($id){
        $id = Crypt::decrypt($id);
        if($this->lists->where('id','=', $id)->delete()){
            return redirect()->route('home')->with('success', "Deleted Successfully");
        }

        return redirect()->route('home')->withErrors('server_error', "Deleted failed. Try again");

    }
}
