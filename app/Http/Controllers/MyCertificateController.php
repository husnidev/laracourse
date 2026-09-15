<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MyCertificateController extends Controller
{
    public function index(){
        $certificates = DB::table('certificates as cert')
            ->select('cert.*', 'c.title as course_title', 'c.slug as course_slug',
            'cat.name as category_name', 'u.name as teacher_name')
            ->join('courses as c', 'cert.course_id', '=', 'c.id')
            ->leftJoin('categories as cat', 'c.category_id', '=', 'cat.id')
            ->leftJoin('users as u', 'c.teacher_id', '=', 'u.id')
            ->where('cert.student_id', Auth::id())
            ->orderBy('cert.issue_date', 'desc')
            ->get();

            $cert_id = $request->id ?? '';
            $cert_detail = DB::table('certificates as cert')
            ->select('cert.*', 'c.title as course_title', 'c.description as course_desc',
            'cat.name as category_name', 'u.name as teacher_name', 's.name as student_name', 's.email as student_email')
            ->join('courses as c', 'cert.course_id', '=', 'c.id')
            ->join('users as s', 'cert.student_id', '=', 's.id')
            ->leftJoin('categories as cat', 'c.category_id', '=', 'cat.id')
            ->leftJoin('users as u', 'c.teacher_id', '=', 'u.id')
            ->where([
                'cert.id' => $cert_id,
                'cert.student_id' => Auth::id()
            ])
            ->first();

            return view('my-certificates.index', compact('certificates', 'cert_detail'));

    }

}
