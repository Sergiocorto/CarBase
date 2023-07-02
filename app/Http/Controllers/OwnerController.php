<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    static public function checkAndStoreOwner($name)
    {
        $owner = Owner::where('name', $name)->first();

        if ($owner) {
            $ownerId = $owner->id;
        } else {
            $newOwner = new Owner();
            $newOwner->name = $name;
            $newOwner->save();

            $ownerId = $newOwner->id;
        }
        return $ownerId;
    }
}
