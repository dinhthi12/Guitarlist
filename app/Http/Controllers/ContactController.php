<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        // $allCom = DB::table('comments')->join('users' , 'users.id', '=', 'comments.user_id')->join('products', 'products.id', '=', 'comments.pro_id')
        // ->select('comments.*', 'users.name', 'products.name')->get();
        $allContact = Contact::all();
        view()->share('allContact', $allContact);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allUser = Contact::all();
        $allContact = Contact::all();
        return view('admin.pages.contacts.index')->with(compact('allUser', 'allContact'));
    }
}
