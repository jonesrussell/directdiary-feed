<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Chat;
use Inertia\Inertia;
use Musonza\Chat\Http\Requests\ClearConversation;
use Musonza\Chat\Http\Requests\DeleteMessage;
use Musonza\Chat\Http\Requests\GetParticipantMessages;
use Musonza\Chat\Http\Requests\StoreMessage;

class ConversationMessageController extends Controller
{
    protected $messageTransformer;

    public function __construct()
    {
        $this->setUp();
    }

    private function setUp()
    {
        if ($messageTransformer = config('musonza_chat.transformers.message')) {
            $this->messageTransformer = app($messageTransformer);
        }
    }

    private function itemResponse($message)
    {
        logger('itemResponse');
        if ($this->messageTransformer) {
            return fractal($message, $this->messageTransformer)->respond();
        }

        return response($message);
    }

    public function index(GetParticipantMessages $request, $conversationId)
    {
        logger('index');
        $conversation = Chat::conversations()->getById($conversationId);
        $participants = $conversation->getParticipants();
        $message = Chat::conversation($conversation)
            ->setParticipant($request->getParticipant())
            ->setPaginationParams($request->getPaginationParams())
            ->getMessages();

        $data = [
            'messages' => $message,
            'participants' => $participants
        ];

        if ($this->messageTransformer) {
            $data = fractal($data, $this->messageTransformer)->toArray();
        }

        return Inertia::render('Messages/Messages', [
            'form' => [
                'response' => [
                    'data' => $data
                ]
            ]
        ]);
    }

    public function show(GetParticipantMessages $request, $conversationId, $messageId)
    {
        logger('show');
        $message = Chat::messages()->getById($messageId);

        return $this->itemResponse($message);
    }

    /**
     * @param  \Musonza\Chat\Http\Requests\StoreMessage  $request
     * @param                                            $conversationId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(StoreMessage $request, $conversationId): \Illuminate\Http\Response | \Illuminate\Http\JsonResponse | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        $conversation = Chat::conversations()->getById($conversationId);
        $message      = Chat::message($request->getMessageBody())
            ->from($request->getParticipant())
            ->to($conversation)
            ->send();

        return $this->itemResponse($message);
    }

    public function deleteAll(ClearConversation $request, $conversationId)
    {
        $conversation = Chat::conversations()->getById($conversationId);
        Chat::conversation($conversation)
            ->setParticipant($request->getParticipant())
            ->clear();

        return response('');
    }

    public function destroy(DeleteMessage $request, $conversationId, $messageId)
    {
        $message = Chat::messages()->getById($messageId);
        Chat::message($message)
            ->setParticipant($request->getParticipant())
            ->delete();

        return response('');
    }
}
