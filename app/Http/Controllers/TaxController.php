<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Model\Tax;
class TaxController extends Controller
{
    public function index(){

        return Tax::all();
    }
}
