<?php namespace Butler\Http\Controllers;

use Butler\Http\Requests;
use Butler\Models\Message;
use Butler\Services\ButlerPusher;

class TinkerController extends Controller
{


    function __construct()
    {
    }

    public function index()
    {
        // Testing Butler
        $api_url = route('apiv1.publish');
        $app_id = '10ynvd32';
        $app_key = 'edf60fd74b03f5e236c6b5b58e17e373b9026064';
        $app_secret = 'f5655bef79378ccdda504c1cceb5359a217b742e';

        $channel = 'MyChannel';
        $event = 'something_happened';
        $data = [
            'some' => 'value',
            'and' => 'another value',
        ];

        $butler = new ButlerPusher($api_url, $app_id, $app_key, $app_secret);
        $butler->publish($event, $channel, $data);
    }
}
