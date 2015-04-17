@extends('layouts.app')

@section('content')
<div class="container" ng-app="butler">
    <h1 class="page-header"><i class="fa fa-file-text-o"></i> Getting Started</h1>
    <div class="row">
        <div class="col-md-12">
            <h4>Step 1 - Create You App</h4>
            <p class="text-justify">
                Create you <code>App</code> here and make note of <code>app id</code>, <code>key</code> and the <code>secret</code>. You can have any number of <code>App</code>
                you like.
            </p>

            <br>

            <h4>Step 2 - Required Files</h4>
            <p class="text-justify">Then you need to have the <code>Butler.php</code> and <code>butler-js.js</code> files at hand:</p>
            <ul>
                <li><a href="{{ route('doc.download', 'php') }}">Butler.php</a></li>
                <li><a href="{{ route('doc.download', 'js') }}">butler-js.js</a></li>
            </ul>

            <br>

            <h4>Step 3 - The Backend</h4>
            <p class="text-justify">
                Let's start on the backend (where you need to <code>publish</code> that you did something). You can keep the <code>Butler.php</code> file wherever you want but when
                you need to <code>publish</code> an event, you can <code>use</code> that class like so:
            </p>
<pre>
&lt;?php namespace MyAwesomeNamespace;

use Butler\Location;

class MyEventPublisher {

    public function publish($data) {
        $api_url = "http://my.publish-api.endpoint"; // The Publish API Endpoint
        $app_id = '10ynvd32';
        $app_key = 'edf60fd74b03f5e236c6b5b58e17e373b9026064';
        $app_secret = 'f5655bef79378ccdda504c1cceb5359a217b742e';

        // These can be anything, but remember, these are used by your JavaScript as shown in the next step
        $channel = 'MyChannel';
        $event = 'something_happened';

        $butler = new Butler($api_url, $app_id, $app_key, $app_secret);
        $butler->publish($event, $channel, $data);
    }
}
</pre>

            <br>

            <h4>Step 4 - The Frontend</h4>
            <p class="text-justify">
                And on the frontend (where you need to <code>subscribe</code> to some events), your JavaScript section may look like:
            </p>
<pre>
    ...
    &lt;!-- My Content --&gt;
    ...


    &lt;script type="text/javascript" src="socket.io-client.js"&gt;&lt;/script&gt;
    &lt;script type="text/javascript" src="butler-js.js"&gt;&lt;/script&gt;
    &lt;script type="text/javascript"&gt;
    (function() {
        var app_key = 'edf60fd74b03f5e236c6b5b58e17e373b9026064',
            butler = new Butler(app_key);

        var channel = butler.subscribe('MyChannel');

        channel.on('something_happened', function(data) {
            // Do whatever you want with your data
            console.log(data);
        });
    })();
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;
</pre>
            <p>
                I have included <code>butler-js.js</code> on the same directory but it can be kept anywhere just remember to <code>src</code> it properly. And finally
                we need the <strong>Socket.IO Client</strong> JavaScript library as well. Please visit <a href="http://socket.io/download/" rel="nofollow" target="_blank">their
                website</a> and download (or link from CDN) the <strong>Socket.IO Client</strong> JavaScript library.
            </p>

            <br>

            <h4>Step 5 - Enjoy</h4>
        </div>
    </div>
</div>
@endsection
