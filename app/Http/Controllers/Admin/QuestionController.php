<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;
use App\Http\Traits\Banner;
use Inertia\Inertia;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class QuestionController extends Controller
{
    use Banner;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('exam_id', 'question', 'img_path', 'choices');

        // $request->validate([
        //     'img_path' => 'required|mimes:jpg,jpeg,png|max:2048'
        //  ]);
         
        $path = null;
        if ($request->hasFile('img_path')) {
            $path = $request->file('img_path')->store('public/photos');
        }

        $question = Question::create([
            'exam_id' => $data['exam_id'],
            'question' => $data['question'],
            'img_path' => $path,
        ]);


        foreach ($data['choices'] as $opt) {
            $path1 = null;
            if ($opt['img_path']) {
                $path1 = $opt['img_path']->store('public/photos');
            }
            Choice::create([
                'question_id' => $question->id,
                'option' => $opt['option'],
                'is_correct' => $opt['is_correct'],
                'img_path' => $path1
            ]);
        }

        $this->flash('Question added', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return Inertia::render('Admin/Question/Edit', [
            'question' => [
                'exam_id' => $question->exam_id,
                'id' => $question->id,
                'question' => $question->question,
                'img_path' => $question->append('img_url')->img_path,
                'img_url' => $question->append('img_url'),
                'choices' => $question->choices()->get()->append('img_url'),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        $question->exam_id = $request->get('exam_id');
        $question->question = $request->get('question');

        if ($question->save()) {
            $options = $request->get('choices');

            foreach ($options as $key => $option) {

                $answer = Choice::find($option['id']);
                $answer->option = $option['option'];
                $answer->is_correct = $option['is_correct'];
                $answer->save();
            };

            $this->flash('Question updated', 'success');

            return redirect()->back();
        }

        // $data = $request->only('exam_id', 'question', 'img_path', 'choices');

        // $path = null;
        // if ($request->hasFile('img_path')) {
        //     $path = $request->file('img_path')->store('public/photos');
        // }

        // $question->update([
        //     'exam_id' => $data['exam_id'],
        //     'question' => $data['question'],
        //     'img_path' => $path,
        // ]);

        // $choice = Choice::query();
        // foreach ($data['choices'] as $opt) {
        //     $path1 = null;
        //     // if ($opt['img_path']) {
        //     //     $path1 = $opt['img_path']->store('public/photos');
        //     // }
        //     $choice->update([
        //         'question_id' => $question->id,
        //         'option' => $opt['option'],
        //         'is_correct' => $opt['is_correct'],
        //         'img_path' => $path1
        //     ]);
        // }

        // $this->flash('Question updated', 'success');

        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $d = Question::find($id);
        $exam_id = $d->exam_id;
        $d->delete();


        $this->flash('Question removed.', 'success');
        return redirect()->route("admin.exams.show", $exam_id);
    }
}
