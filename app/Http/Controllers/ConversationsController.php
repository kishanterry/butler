<?php namespace Butler\Http\Controllers;

use Butler\Commands\ConversationsCommand;
use Butler\Http\Requests;
use Butler\Http\Requests\ConversationRequest;
use Butler\Models\User;
use Butler\Repositories\Eloquent\ConversationRepository;
use Butler\Repositories\Eloquent\MessageRepository;
use Illuminate\Auth\Guard;
use JavaScript;

class ConversationsController extends Controller
{
    /**
     * @var ConversationRepository
     */
    private $conversationRepo;

    /**
     * @var MessageRepository
     */
    private $messageRepo;

    /**
     * @var Guard
     */
    private $auth;

    /**
     * @param ConversationRepository $conversationRepo
     * @param MessageRepository $messageRepo
     * @param Guard $auth
     */
    function __construct(ConversationRepository $conversationRepo, MessageRepository $messageRepo, Guard $auth)
    {
        parent::__construct();

        $this->conversationRepo = $conversationRepo;
        $this->auth = $auth;
        $this->messageRepo = $messageRepo;
    }


    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        JavaScript::put([
            'AUTH_USER_ID' => $this->auth->user()->id,
        ]);

        return view('conversations.home');
    }

    /**
     * @param int $page
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($page = 0)
    {
        return $this->conversationRepo->with(['owner', 'users', 'messages.creator'])->allForUser($this->auth->user()->id, $page);
    }

    /**
     * @param $conversation_id
     * @return mixed
     */
    public function messages($conversation_id)
    {
        if ($conversation_id) {
            return $this->messageRepo->scope('ofConversation', $conversation_id)->with(['creator'])->all();
        }

        abort(404);
    }

    /**
     * @param ConversationRequest $request
     * @return mixed
     */
    public function send(ConversationRequest $request)
    {
        return $this->dispatch(
            new ConversationsCommand($this->auth->user(), $request, $this->conversationRepo, $this->messageRepo)
        );
    }

	/**
	 * @param null $search_term
	 * @return array
     */
	public function searchUsers($search_term = null)
    {
        if ($search_term) {
            $users = User::where('name', 'like', '%' . $search_term . '%')
            	->orWhere('email', 'like', '%' . $search_term . '%')
				->get();

            $users = $users->filter(function($user) {
                return $user->id !== $this->auth->user()->id;
            });

            return array_flatten($users);
        }

        return [];
    }
}
