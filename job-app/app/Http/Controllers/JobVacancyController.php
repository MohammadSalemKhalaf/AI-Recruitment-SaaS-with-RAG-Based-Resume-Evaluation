<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class JobVacancyController extends Controller
{
    public function show($id)
    {
        $job = JobVacancy::findOrFail($id);
        return view('job.show', compact('job'));
    }

    public function apply($id)
    {
        $job = JobVacancy::findOrFail($id);
        $user = auth()->user();

        return view('job.apply', compact('job', 'user'));
    }

    public function storeApplication(Request $request, $id)
    {
        $job = JobVacancy::findOrFail($id);
        $user = auth()->user();

        $validated = $request->validate([
            'resume_id' => 'required|exists:resumes,id',
            'cover_letter' => 'nullable|string|max:2000',
        ]);

        $existingApplication = JobApplication::where('userId', $user->id)
            ->where('jobVacancyId', $job->id)
            ->exists();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this job!');
        }

        JobApplication::create([
            'userId' => $user->id,
            'jobVacancyId' => $job->id,
            'resumeId' => $validated['resume_id'],
            'status' => 'pending',
        ]);

        return redirect()->route('job-applications.index')
                       ->with('success', 'Application submitted successfully!');
    }
}
