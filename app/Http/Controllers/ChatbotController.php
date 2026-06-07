<?php

namespace App\Http\Controllers;

use App\Http\Traits\Banner;
use App\Imports\ChatbotsImport;
use App\Models\Chatbot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Google\Cloud\Dialogflow\V2\Client\IntentsClient;
use Google\Cloud\Dialogflow\V2\Intent;
use Google\Cloud\Dialogflow\V2\Intent\TrainingPhrase;
use Google\Cloud\Dialogflow\V2\Intent\TrainingPhrase\Part;
use Google\Cloud\Dialogflow\V2\Intent\Message;
use Google\Cloud\Dialogflow\V2\Intent\Message\Text;
use Google\Cloud\Dialogflow\V2\CreateIntentRequest;
use Google\Cloud\Dialogflow\V2\ListIntentsRequest;
use Google\Cloud\Dialogflow\V2\DeleteIntentRequest;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    use Banner;

    public function syncToDialogflow()
    {
        $projectId = env('DIALOGFLOW_PROJECT_ID');
        if (!$projectId) {
            $this->flash('Dialogflow Project ID not configured.', 'danger');
            return back();
        }

        try {
            $intentsClient = new IntentsClient();
            $parent = $intentsClient->agentName($projectId);
            
            // Delete existing FAQ intents first to avoid duplicates
            $listRequest = (new ListIntentsRequest())->setParent($parent);
            $pagedResponse = $intentsClient->listIntents($listRequest);
            
            foreach ($pagedResponse->iterateAllElements() as $existingIntent) {
                if (str_starts_with($existingIntent->getDisplayName(), 'FAQ_')) {
                    $deleteRequest = (new DeleteIntentRequest())->setName($existingIntent->getName());
                    $intentsClient->deleteIntent($deleteRequest);
                }
            }

            // Sync current FAQs
            $faqs = Chatbot::all();
            
            foreach ($faqs as $faq) {
                $intent = new Intent();
                $displayName = 'FAQ_' . $faq->id . '_' . Str::slug(substr($faq->category, 0, 15));
                $intent->setDisplayName($displayName);

                $part = new Part();
                $part->setText($faq->question);
                
                $trainingPhrase = new TrainingPhrase();
                $trainingPhrase->setParts([$part]);
                $intent->setTrainingPhrases([$trainingPhrase]);

                $text = new Text();
                $text->setText([$faq->answer]);
                
                $message = new Message();
                $message->setText($text);
                $intent->setMessages([$message]);

                $createRequest = (new CreateIntentRequest())
                    ->setParent($parent)
                    ->setIntent($intent);
                    
                $intentsClient->createIntent($createRequest);
            }
            
            $intentsClient->close();
            
            \App\Models\SyncLog::create([
                'admin_id' => auth()->id(),
                'status' => 'success',
                'message' => 'Successfully synced ' . count($faqs) . ' FAQs to Dialogflow!',
                'synced_intents_count' => count($faqs),
            ]);

            $this->flash('Successfully synced ' . count($faqs) . ' FAQs to Dialogflow!', 'success');
            
        } catch (\Exception $e) {
            Log::error("Dialogflow Sync Error: " . $e->getMessage());
            
            \App\Models\SyncLog::create([
                'admin_id' => auth()->id(),
                'status' => 'failed',
                'message' => $e->getMessage(),
                'synced_intents_count' => 0,
            ]);

            $this->flash('Failed to sync to Dialogflow. Check logs.', 'danger');
        }
        
        return back();
    }

    public function index(Request $request)
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:category,question,answer'],
        ]);

        $data = Chatbot::orderBy('created_at', 'desc');

        $perpage = $request->input('perpage') ?: 25;
        $search_keyword = request('search');

        if (request('search')) {
            $data
                ->where('category', 'like', '%' . request('search') . '%')
                ->orwhere('question', 'like', '%' . request('search') . '%')
                ->orWhere('answer', 'like', '%' . request('search') . '%');
        }


        if (request()->has(['category'])) {
            $data->where('category', 'like', '%' . request('category') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $data->orderBy(request('field'), request('direction'))->get();
        }

        return Inertia::render('Admin/Chatbot/Index', [
            'concerns' => $data->paginate($perpage)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'perpage', 'category']),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'category' => ['required', 'string'],
            'question' => ['required', 'string'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        Chatbot::create([
            'category' => $request['category'],
            'question' => Str::of($request['question'])->ucfirst(),
            'answer' => Str::of($request['answer'])->ucfirst(),
        ]);

        if ($val) {
            $this->flash('New question for chatbot added.', 'success');
        }

        return redirect()->route('admin.chatbot.index');
    }

    public function show(Chatbot $chatbot)
    {
        //
    }

    public function edit(Chatbot $chatbot)
    {
        //
    }

    public function update(Request $request, Chatbot $chatbot)
    {
        $val = Validator::make($request->all(), [
            'category' => ['required'],
            'question' => ['required'],
        ]);

        if ($val->fails()) {
            $this->flash($val->errors()->first(), 'danger');
            return back();
        }

        $chatbot->update([
            'category' => $request['category'],
            'question' => Str::of($request['question'])->ucfirst(),
            'answer' => Str::of($request['answer'])->ucfirst(),
        ]);

        $this->flash('Question updated!', 'success');

        return redirect()->route('admin.chatbot.index');
    }

    public function destroy($id)
    {
        $d = Chatbot::find($id);
        $d->delete();

        $this->flash('Question removed.', 'success');

        return redirect()->route('admin.chatbot.index');
    }

    public function import()
    {
        Excel::import(new ChatbotsImport, request()->file('file'));

        return back();
    }
}
