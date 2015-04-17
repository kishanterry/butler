<?php namespace Butler\Http\Controllers;

use Butler\Commands\AppsCommand;
use Butler\Http\Requests\CreateAppRequest;
use Butler\Repositories\Eloquent\AppRepository;
use Illuminate\Auth\Guard;
use JavaScript;

class AppsController extends Controller
{

    /**
     * @var AppRepository
     */
    private $appRepo;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param AppRepository $appRepo
     * @param Guard $auth
     */
    function __construct(AppRepository $appRepo, Guard $auth)
    {
        parent::__construct();
        $this->appRepo = $appRepo;
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        JavaScript::put([
            'AUTH_USER_ID' => app('hashids')->encode($this->auth->user()->id),
        ]);

        return view('apps.index');
    }

    /**
     * @param null $user_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function all($user_id = null)
    {
        if ($user_id) {
            return $this->appRepo->scope('ofUser', app('hashids')->decode($user_id))->all();
        }

        return response(null);
    }

    /**
     * @param CreateAppRequest $request
     * @return mixed
     */
    public function store(CreateAppRequest $request)
    {
        return $this->dispatch(
            new AppsCommand($this->auth->user(), $request, $this->appRepo)
        );
    }
}
