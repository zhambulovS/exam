<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'exam_name',
        'subject_id',
        'date',
        'time',
        'attempt',
        'enterance_id'
    ];
    public function subject(){
        return $this->hasMany(Subject::class, 'id', 'subject_id');
    }

    public function getQnaExam(){
        return $this->hasMany(QnaExam::class, 'exam_id', 'id');
    }
}
