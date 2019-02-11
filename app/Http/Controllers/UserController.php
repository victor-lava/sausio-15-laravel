<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
// use App\Statistic;
class UserController extends Controller
{
    public function index($id) {
        // $user = User::where('id', $id)->first(); // first() grazina viena objekta, tinkamas naudoti gaunant tik viena duomenį
        $user = User::find($id); // gali grazinti vieną objektą arba collection
        // $statistic = Statistic::where('user_id', $id)->first(); // SELECT * FROM statistics WHERE user_id = $user_id
        // dd($statistic);
        if($user) {
            return view('/user', compact('user'));
        } else {
            return redirect()->route('home');
        }
    }
    public function games($id) {
        $user = User::find($id);
        if($user) {
            return view('/user-games', compact('user'));
        } else {
            return redirect()->route('home');
        }
    }
}