<?php namespace Butler\Http\Controllers\Api\v1;

use Butler\Commands\ApiPublishEventCommand;
use Butler\Http\Controllers\Controller;
use Butler\Repositories\Eloquent\AppRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @var AppRepository
     */
    private $appRepo;

    /**
     * @param AppRepository $appRepo
     */
    function __construct(AppRepository $appRepo)
    {
        $this->appRepo = $appRepo;
    }

    public function publish(Request $request)
    {
        return $this->dispatch(
            new ApiPublishEventCommand($request, $this->appRepo)
        );
    }
}
