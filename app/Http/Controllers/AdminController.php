<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\Question;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class AdminController extends Controller
{
    public function examDashboard()
    {
        $subjects = Subject::all();
        $exams = Exam::with('subject')->get();
        return view('admin.exam-dashboard', ['subjects'=>$subjects, 'exams'=>$exams]);
    }
    public function qnaDashboard()
    {
        $questions = Question::with('answers')->get();
        return view('admin.qnaDashboard', compact('questions'));
    }
//--------------------------------------------------
    public function addSubject(Request $request)
    {
        try {
            $subject = $request->subject;
            if(empty($subject)) {
                return response()->json(['success' => false, 'msg' => 'Subject name is empty.']);
            }

            Subject::insert([
                'subject' => $subject,
            ]);
            return response()->json(['success' => true, 'msg' => 'Subject added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function editSubject(Request $request){
        try {
            $subject = Subject::find($request->id);
            $subject->subject = $request->subject;
            $subject->save();
            return response()->json(['success' => true, 'msg' => 'Subject updated successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function deleteSubject(Request $request){
        try{
            Subject::where('id', $request->id)->delete();
            return response()->json(['success' => true, 'msg' => 'Subject deleted successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function addExam(Request $request){
        try{
            $unique_id = uniqid('exid');
            Exam::insert([
                'exam_name'=>$request->exam_name,
                'subject_id'=>$request->subject_id,
                'date'=>$request->date,
                'time'=>$request->time,
                'enterance_id'=>$unique_id,
            ]);
            return response()->json(['success' => true, 'msg' => 'Exam added successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function editExam(Request $request)
    {
        try {
            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id; // This was missing
            $exam->date = $request->date;             // Corrected field name
            $exam->time = $request->time;             // Corrected field name
            $exam->save();

            return response()->json(['success' => true, 'msg' => 'Exam updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function deleteExam(Request $request){
        try{
            Exam::where('id', $request->id)->delete();
            return response()->json(['success' => true, 'msg' => 'Exam deleted successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getExamDetail($id)
    {
        try{
            $exam = Exam::where('id', $id)->get();
            return response()->json(['success' => true, 'data' => $exam,'msg' => 'Exam added successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
        //QUESTIONS AND ANSWERS
    public function addQna(Request $request)
    {
        try {
            $questionsId = Question::insertGetId([
                'question'=> $request->question,
            ]);

            foreach($request->answers as $answer){
                $is_correct = 0;
                if($request->is_correct == $answer){
                    $is_correct = 1;
                }
                Answer::insert([
                    'questions_id' => $questionsId,
                    'answers' => $answer,
                    'is_correct' => $is_correct,
                ]);
            }

            return response()->json(['success' => true, 'msg' => 'Question added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getQnaDetail(Request $request)
    {
        $qna = Question::where('id', $request->qid)->with('answers')->get();
        return response()->json(['success' => true, 'data' => $qna,'msg' => 'Question added successfully.']);
    }

    public function deleteAns(Request $request)
    {
        Answer::where('id', $request->id)->delete();
        return response()->json(['success' => true, 'msg' => 'Answer deleted successfully.']);
    }

    public function updateAns(Request $request)
    {
        try{
            Question::where('id', request()->questions_id)->update([
                'question'=>$request->question,
            ]);
            if(isset($request->answers)){
                foreach($request->answers as $key => $value){
                    $is_correct = 0;
                    if($request->is_correct == $value){
                        $is_correct = 1;
                    }
                    Answer::where('id', $key)->update([
                        'questions_id' => $request->questions_id,
                        'answers' => $value,
                        'is_correct' => $is_correct,
                    ]);
                }
            }
            if(isset($request->new_answers)){
                foreach($request->new_answers as $answer){
                    $is_correct = 0;
                    if($request->is_correct == $answer){
                        $is_correct = 1;
                    }
                    Answer::insert([
                        'questions_id' => $request->questions_id,
                        'answers' => $answer,
                        'is_correct' => $is_correct,
                    ]);
                }
            }
            return response()->json(['success' => true, 'msg' => 'Question updated successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function deleteQnaAns(Request $request)
    {
        Question::where('id', $request->id)->delete();
        Answer::where('questions_id', $request->id)->delete();
        return response()->json(['success' => true, 'msg' => 'Question deleted successfully.']);
    }
    //STUDENTS
    public function studentList()
    {
        $students = User::where('is_admin', 0)->get();
        return view('admin.studentList', compact('students'));
    }
    public function addStudent(Request $request){
        try{
            $password = Str::random(8);
            User::insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($password),
            ]);
            return response()->json(['success'=>true, 'msg'=>'Students added']);

        }catch (\Exception $e){
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function editStudent(Request $request)
    {
        try{
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json(['success'=>true, 'msg'=>'Students info updates']);

        }catch (\Exception $e){
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function deleteStudent(Request $request){

        try{
            User::where('id', $request->id)->delete();

            return response()->json(['success'=>true, 'msg'=>'Students info updates']);

        }catch (\Exception $e){
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function getQuestions(Request $request)
    {
        try {
            $questions = Question::all();
            if (count($questions) > 0) {
                $data = [];
                $counter = 0;
                foreach ($questions as $question) {
                    $qnaExam = QnaExam::where(['exam_id' => $request->exam_id, 'question_id' => $question->id])->get();

                    if(count($qnaExam) == 0){
                        $data[$counter]['id'] = $question->id;
                        $data[$counter]['question'] = $question->question;
                        $counter++;
                    }
                }
                return response()->json(['success' => true, 'data' => $data, 'msg' => 'Questions retrieved successfully.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'No questions found.']);
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => $th->getMessage()]);
        }
    }

    public function addQuestions(Request $request)
    {
        try{
            if(isset($request->questions_ids)){
                foreach($request->questions_ids as $qid){
                    QnaExam::insert([
                        'exam_id' => $request->exam_id,
                        'question_id' => $qid
                    ]);
                }
            }
            return response()->json(['success' => true, 'msg' => 'Question added successfully.']);
        }catch (\Exception $e){
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function getExamQuestions(Request $request)
    {
        try{
            $data = QnaExam::where('exam_id', $request->exam_id)->with('question')->get();
            return response()->json(['success' => true, 'data' => $data, 'msg' => 'Questions retrieved successfully.']);
        }catch (\Exception $e){
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function deleteExamQuestions(Request $request)
    {
        try {
            $data = QnaExam::where('id', $request->id)->delete();
            return response()->json(['success' => true, 'data'=>$data,'msg' => 'Questions deleted successfully.']);
        }catch (\Exception $e){
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
