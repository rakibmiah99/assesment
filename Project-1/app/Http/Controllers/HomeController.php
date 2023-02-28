<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\ListModel;

class HomeController extends Controller
{
    //CHECK USER AND SET TWO CONSTRUCTOR PROPERTY USER ID AND USER WISE TO DO LIST
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user_id = Auth::id();
            $this->lists = ListModel::where('user_id','=', $this->user_id);
            return $next($request);
        });
    }

    //TO DO LIST PAGE VIEW
    function Page(Request $request){
        $title = "Dashboard || To Do";
        $number_of_view = 10;
        $lists = $this->lists->paginate($number_of_view);
        return view('HomePages.List', compact('lists', 'number_of_view', 'title'));
    }

    //TO DO LIST CREATE PAGE VIEW
    function Create(Request $request){
        $title = "Dashboard || Add New To Do ";
        return view('HomePages.Create', compact('title'));
    }

    //CREATE A NEW TO DO LIST
    function Store(Request $request){
        //INPUT VALIDATION
        $credential = $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'nullable'
        ]);

        if ($credential){
            $credential['user_id'] =  $this->user_id;
            //INSERT A TO DO LIST
            if(ListModel::insert($credential)){
                return redirect()->back()->with('success', 'inserted successfully');
            }
            else{
                //IF SOMEHOW INSERTED FAILED THEN REDIRECT TO PREVIOUS URL WITH A ERROR MESSAGE
                return redirect()->back()->withErrors([
                    'server_error' => 'Something went wrong try again'
                ])->withInput();
            }
        }
    }


    //TO LIST EDIT PAGE VIEW
    function Edit($id){
        $title = "Dashboard || Edit To Do";
        //DECRYPTION ID
        $id = Crypt::decrypt($id);
        $data = $this->lists->find($id);
        return view('HomePages.Update', compact('data', 'title'));
    }

    //UPDATE TO DO LIST
    function Update(Request $request, $id){
        //DECRYPTION ID
        $id = Crypt::decrypt($id);
        //INPUT VALIDATION
        $credential = $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'nullable'
        ]);

        //UPDATE A TO DO LIST
        if ($credential){
            if($this->lists->where('id', '=', $id)->update($credential)){
                return redirect()->back()->with('success', 'updated successfully');
            }
            else{
                //IF SOMEHOW UPDATED FAILED THEN REDIRECT TO PREVIOUS URL WITH A ERROR MESSAGE
                return redirect()->back()->withErrors([
                    'server_error' => 'Something went wrong try again'
                ])->withInput();
            }
        }
    }


    //TO DO DELETE PAGE VIEW
    function Delete($id){
        $title = "Dashboard || Delete To Do ";
        return view('HomePages.Delete', compact('id','title'));
    }

    //DELETE A TO DO LIST
    function Deleted($id){
        $id = Crypt::decrypt($id);
        if($this->lists->where('id','=', $id)->delete()){
            return redirect()->route('home')->with('success', "Deleted Successfully");
        }

        //IF SOMEHOW DELETED FAILED THEN REDIRECT TO PREVIOUS URL WITH A ERROR MESSAGE
        return redirect()->route('home')->withErrors('server_error', "Deleted failed. Try again");

    }
}
