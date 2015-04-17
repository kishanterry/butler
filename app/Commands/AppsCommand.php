<?php namespace Butler\Commands;

use Butler\Models\App;
use Butler\Repositories\Eloquent\AppRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class AppsCommand extends Command implements SelfHandling
{

    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var App
     */
    private $app;

    /**
     * @var AppRepository
     */
    private $appRepo;

    /**
     * Create a new command instance.
     * @param Authenticatable $user
     * @param Request $request
     * @param AppRepository $appRepo
     */
    public function __construct(Authenticatable $user, Request $request, AppRepository $appRepo)
    {
        $this->user = $user;
        $this->request = $request;
        $this->appRepo = $appRepo;
    }

    /**
     * Execute the command.
     *
     */
    public function handle()
    {
        if ($this->request->has('id')) {
            // Update Existing App
            $this->app = $this->appRepo->find($this->request->get('id'));
            $this->app->update($this->request->all());

            return $this->app;
        }

        // Create New App
        return $this->createNewApp();
    }

    /**
     * @return App|mixed
     */
    private function createNewApp()
    {
        $this->app = $this->appRepo->create($this->request->all());
        $this->app->app_id = app('hashids')->encode($this->app->id);
        $this->app->app_key = sha1($this->app->app_id);
        $this->app->app_secret = sha1($this->app->app_key);
        $this->app->user_id = $this->user->id;
        $this->app->enabled = true;

        $this->app->save();
        return $this->app;
    }

}
