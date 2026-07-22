<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index(): string
	{
		return view('home');
	}

	public function details(): string
	{
		return view('details');
	}

	public function games(): string
	{
		return view('games');
	}
}