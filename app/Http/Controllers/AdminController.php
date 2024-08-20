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
        return view('admin.exam-dashboard', ['subjects'=>$subjects]);
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
            return response()->json(['success' => true, 'msg' => 'Exam deleted successfully.']);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

}
