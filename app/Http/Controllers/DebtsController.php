<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtsController extends Controller
{
	public function index()
	{
		return view('debts.index');
	}
}
