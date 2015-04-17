<?php namespace Butler\Http\Controllers;

use Butler\Http\Requests;

class DocumentationController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('documentation');
    }

    public function download($what)
    {
        switch ($what) {
            case 'php':
                $file = public_path('downloads/Butler.php');
                return response()->download($file);
            case 'js':
                $file = public_path('downloads/butler-js.js');
                return response()->download($file);
        }

        abort(404);

    }
}
