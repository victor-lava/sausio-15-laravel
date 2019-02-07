<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $users = User::where('online', 1)
                        ->where('admin', '===', 0)
                        ->get(); // SELECT * FROM users WHERE online = 1 AND WHERE admin === 0
                                // get() grazina collection, kas yra masyvas, del to naudojamas gauti daug duomenų

        // dd($users); // Graziai atvaizduoja, bet ir nukilina procesus kurie eina po juo

        // return view('home', ['users' => $users]);
        return view('pages/home', compact('users'));// ['users' => $users]
    }

    public function kazkas() {
        // echo "sdf";
        // return view('pages/home', compact('users'));
    }

    // public function user(User $user) {
    //     dd($user->name);
    // }

}
