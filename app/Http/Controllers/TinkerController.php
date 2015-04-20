<?php namespace Butler\Http\Controllers;

use Butler\Http\Requests;
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
        $app_id = 'pvwx6wkg';
        $app_key = 'bf24e885728d39b27ccb286a57b19f4dbaa35e90';
        $app_secret = '0c8709a900099b0a5b9ef0d44a35e48aebf8b78e';

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
