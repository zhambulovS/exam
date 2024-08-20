<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
class AdminController extends Controller
{
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

    }
    public function deleteSubject(Request $request){

    }
}
