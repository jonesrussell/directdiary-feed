<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreConversationRequest;
use App\Models\User;
use Chat;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Musonza\Chat\Exceptions\DeletingConversationWithParticipantsException;
use Musonza\Chat\Http\Requests\DestroyConversation;
use Musonza\Chat\Http\Requests\UpdateConversation;
use Musonza\Chat\Models\Conversation;
use Musonza\Chat\Http\Requests\GetParticipantMessages;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Inertia\Inertia;

class ConversationController extends Controller
{
    protected $conversationTransformer;

    public function __construct()
    {
        $this->setUp();
    }

    private function setUp()
    {
        if ($conversationTransformer = config('musonza_chat.transformers.conversation')) {
            $this->conversationTransformer = app($conversationTransformer);
        }
    }

    private function itemResponse($conversation)
    {
        if ($this->conversationTransformer) {
            return fractal($conversation, $this->conversationTransformer)->respond();
        }

        return response($conversation);
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);
        $conversations = Chat::conversations()->setParticipant($user)->isDirect()->get();

        // Fetch the messages for the first conversation
        $firstConversationMessages = []; // Fetch this data accordingly
        if ($conversationId) {
            $firstConversationMessages = ['foo']; // Fetch this data accordingly
        }

        return Inertia::render('Messages/MessagesIndex', [
            'conversations' => $conversations,
            'firstConversationMessages' => $firstConversationMessages,
        ]);
    }

    /**
     * Create a Conversation
     */
    public function store(StoreConversationRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $conversations = Chat::conversations()->setParticipant($user)->isDirect()->get();

        $participants = $request->participants();

        // Get the participants in the conversation
        $participantModel1 = $participants[0];
        $participantModel2 = $participants[1];

        // Check if conversation already exists
        $conversation = Chat::conversations()->between($participantModel1, $participantModel2);

        if ($conversation) {
            return $this->itemResponse($conversation);
        }

        // Create a new conversation
        $conversation = Chat::createConversation($participants)->makeDirect();

        return $this->index();
    }

    public function show(GetParticipantMessages $request, $id = null)
    {
        $user = User::find(Auth::user()->id);
        $conversations = Chat::conversations()->setParticipant($user)->isDirect()->get();

        // Fetch the messages for the first conversation
        $firstConversationMessages = []; // Fetch this data accordingly

        $conversation = Chat::conversations()->getById($id);

        return Inertia::render('Messages/MessagesIndex', [
            'conversations' => $conversations,
            'conversation' => $conversation,
        ]);
    }

    public function update(UpdateConversation $request, $id)
    {
        /** @var Conversation $conversation */
        // $conversation = Chat::conversations()->getById($id);
        // $conversation->update(['data' => $request->validated()['data']]);

        // return $this->itemResponse($conversation);
    }

    /**
     * @param  DestroyConversation  $request
     * @param                       $id
     *
     * @return ResponseFactory|Response
     * @throws Exception
     *
     */
    public function destroy(DestroyConversation $request, $id)
    {
        /** @var Conversation $conversation */
        // $conversation = Chat::conversations()->getById($id);

        // try {
        //     $conversation->delete();
        // } catch (Exception $e) {
        //     if ($e instanceof DeletingConversationWithParticipantsException) {
        //         abort(HttpResponse::HTTP_FORBIDDEN, $e->getMessage());
        //     }

        //     throw $e;
        // }

        // return response($conversation);
    }
}
