<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
  
 
    public function create(Job $job)
    {
        $this->authorize('apply', $job);
        return view('job_application.create', ['job' => $job]);
    }


    public function store(Job $job, Request $request)
    {
        
        $this->authorize('apply', $job);

        $validatedData = $request->validate([
                'expected_salary' => 'required|min:1|max:1000000',
                'cv' => 'required|mimes:pdf|max:2048'
         ]);

         $file = $request->file('cv');
         $path =$file->store('csv', 'private');
         //store 方法的第一個參數是存儲文件的目錄（相對於指定磁碟的根目錄）。
         //store 方法的第二個參數是指定的磁碟名稱，這裡是 'private'。
         $job->jobApplications()->create([
            'user_id' => $request->user()->id,
            'expected_salary' => $validatedData['expected_salary'],
            'cv_path' => $path
            ]);
            
            return redirect()->route('jobs.show',$job)
            ->with('success', 'Job application submitted.');

    }


    public function destroy(string $id)
    {
        //
    }
}
