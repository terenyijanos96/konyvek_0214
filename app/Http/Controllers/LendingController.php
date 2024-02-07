<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = response()->json(Lending::all());
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lending = new Lending();
        $lending->fill($request->all());
        $lending->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id, $copy_id, $start)
    {
        return Lending::where('user_id', $user_id)->where('copy_id', $copy_id)->where('start', $start)->first();
    }


    public function update(Request $request, $user_id, $copy_id, $start)
    {
        $lending = $this->show($user_id, $copy_id, $start);
        $lending->fill($request->all());
        $lending->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id, $copy_id, $start)
    {
        $this->show($user_id, $copy_id, $start)->delete();
    }

    public function allLendingUserCopy()
    {
        //a modellben megírt függvények 
        //neveit használom
        $datas = Lending::with(['users', 'copies'])
            ->get();
        return $datas;
    }

    public function lendingsCountByUser()
    {
        $user = Auth::user();    //bejelentkezett felhasználó
        $lendings = Lending::with('users')->where('user_id', '=', $user->id)->count();
        return $lendings;
    }


    public function broughtBackOn($date)
    {
        return DB::table('lendings as l')
            ->selectRaw('title, author')
            ->join('copies as c', 'l.copy_id', 'c.copy_id')
            ->join('books as b', 'c.book_id', 'b.book_id')
            ->where('end', $date)->get();
    }
}
