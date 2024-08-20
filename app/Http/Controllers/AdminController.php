<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Subject;
class AdminController extends Controller
{
    public function examDashboard()
    {
        $subjects = Subject::all();
        $exams = Exam::with('subject')->get();
        return view('admin.exam-dashboard', ['subjects'=>$subjects, 'exams'=>$exams]);
    }

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
            Exam::insert([
                'exam_name'=>$request->exam_name,
                'subject_id'=>$request->subject_id,
                'date'=>$request->date,
                'time'=>$request->time,
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

    public function deleteExam(Request $request){}
    public function getExamDetail($id)
    {
        try{
            $exam = Exam::where('id', $id)->get();
            return response()->json(['success' => true, 'data' => $exam,'msg' => 'Exam added successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }



}
