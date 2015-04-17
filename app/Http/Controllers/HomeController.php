<?php namespace Butler\Http\Controllers;

class HomeController extends Controller {

	/**
	 *
     */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * @return \Illuminate\View\View
     */
	public function getDashboard()
	{
		return view('dashboard');
	}

}
