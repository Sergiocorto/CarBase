<?php

namespace App\Http\Controllers;

use App\Models\Make;
use Illuminate\Http\Request;

class MakeController extends Controller
{
    static public function checkAndStoreMake($makeName)
    {
        $make = Make::where('name', $makeName)->first();

        if ($make) {
            $makeId = $make->id;
        } else {
            $newMake = new Make();
            $newMake->name = $makeName;
            $newMake->save();

            $makeId = $newMake->id;
        }
        return $makeId;
    }
}
