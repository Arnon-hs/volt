<?php

namespace App\Http\Controllers;

use App\Models\NFCCard;
use App\Models\User;
use Inertia\Inertia;

class NFCController extends Controller
{
    public function index()
    { 
        $nfc_cards = NFCCard::all();
        $users = User::all();
//        dd($nfc_cards);
        return Inertia::render('NFC/Index', compact('nfc_cards', 'users'));
    }
}
