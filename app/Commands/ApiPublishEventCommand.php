<?php namespace Butler\Commands;

use Butler\Models\App;
use Butler\Repositories\Eloquent\AppRepository;
use Butler\Services\ApiRequestValidation;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;
use Symfony\Component\Security\Core\Util\StringUtils;

class ApiPublishEventCommand extends Command implements SelfHandling
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var AppRepository
     */
    private $appRepo;

    /**
     * @var App
     */
    private $app;

    /**
     * Create a new command instance.
     * @param Request $request
     * @param AppRepository $appRepo
     */
    public function __construct(Request $request, AppRepository $appRepo)
    {
        $this->request = $request;
        $this->appRepo = $appRepo;
    }

    /**
     * @return mixed|string
     */
    public function handle()
    {
        if ($this->isValidApiCall()) {
            $content = json_decode($this->request->getContent(), true);
            if ($this->hasValidData($content)) {
                return $this->publish($content);
            }
        }

        return 'ERROR';
    }

    /**
     * @param $content
     * @return mixed
     */
    private function publish($content)
    {
        $channel = array_pull($content, 'channel');
        $event = array_pull($content, 'event');
        $content = json_encode($content);

        $redis = app('redis')->connection();
        return $redis->publish($this->app->app_key . ':' . $channel . ':' . $event, $content);
    }

    /**
     * @return bool
     */
    private function isValidApiCall()
    {
        $app_key = filter_var($this->request->header('X-Public'), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->app = $this->appRepo->findBy('app_key', $app_key)->first();

        if ($this->app) {
            $app_secret = $this->app->app_secret;
            return ApiRequestValidation::validate($this->request, $app_secret);
        }

        return false;
    }

    /**
     * @param $content
     * @return string
     */
    private function hasValidData($content)
    {
        if (
            array_key_exists('channel', $content) &&
            array_key_exists('event', $content)
        ) {
            if (
                !StringUtils::equals('', trim($content['channel'])) &&
                !StringUtils::equals('', trim($content['event']))
            ) {
                return true;
            }
            return false;
        }

        return false;
    }
}
