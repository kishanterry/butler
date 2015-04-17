<?php namespace Butler\Commands;

use Butler\Repositories\Eloquent\ConversationRepository;
use Butler\Repositories\Eloquent\MessageRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class ConversationsCommand extends Command implements SelfHandling
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
     * @var ConversationRepository
     */
    private $conversationRepo;

    /**
     * @var MessageRepository
     */
    private $messageRepo;

	/**
	 * @param Authenticatable $user
	 * @param Request $request
	 * @param ConversationRepository $conversationRepo
	 * @param MessageRepository $messageRepo
	 */
    public function __construct(Authenticatable $user, Request $request, ConversationRepository $conversationRepo, MessageRepository $messageRepo)
    {
        $this->user = $user;
        $this->request = $request;
        $this->conversationRepo = $conversationRepo;
        $this->messageRepo = $messageRepo;
    }

    /**
     * Execute the command.
     *
     */
    public function handle()
    {
        $conversation = null;

        if ($this->request->has('conversation_id')) {
			$conversation = $this->conversationRepo->find($this->request->get('conversation_id'));
		} else {
            $conversation = $this->createConversation();
        }

        if ($conversation) {
            $this->syncPivotTable($conversation);
            $this->saveMessage($conversation);
            $conversation->load('owner', 'users', 'messages.creator');

			return $conversation;
        }

		return [];
    }

    /**
     * @param $conversation
     */
    private function syncPivotTable($conversation)
    {
        $to = $this->request->get('to');
        $to = array_pluck($to, 'id');
        $to[] = $this->user->id;

        $conversation_user = [];
        foreach ($to as $key => $user_id) {
            $conversation_user[$user_id] = ['seen' => 0];
        }

        $conversation->users()->sync($conversation_user);
        $conversation->update();
    }

    /**
     * @param $conversation
     */
    private function saveMessage($conversation)
    {
        $message = $this->messageRepo->create([
            'message' => $this->request->get('message')
        ]);

        $message->conversation_id = $conversation->id;
        $message->user_id = $this->user->id;
        $message->save();
    }

    /**
     * @return mixed
     */
    private function createConversation()
    {
        $conversation = $this->conversationRepo->create([]);
        $conversation->created_by = $this->user->id;
        $conversation->save();
        return $conversation;
    }

}
