<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\Resume;
use App\Http\Requests\ApplyJobRequest;
use App\Services\ResumeAnalysisService;
use Throwable;
class JobVacancyController extends Controller
{
    public function __construct(private ResumeAnalysisService $resumeAnalysisService)
    {
    }

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


    public function storeApplication(ApplyJobRequest $request, $id)
    {
        $job  = JobVacancy::findOrFail($id);
        $user = auth()->user();

        $request->validated();

        $resumeId = $request->input('resume_id');

        if (empty($resumeId) && !$request->hasFile('resume_file')) {
            return back()->withErrors(['resume_file' => 'Please select an existing resume or upload a new one.']);
        }

        $existingApplication = JobApplication::where('userId', $user->id)
            ->where('jobVacancyId', $job->id)
            ->exists();

        if ($existingApplication) {
            return back()->withErrors(['resume_id' => 'You have already applied for this job!']);
        }

        $selectedResume = null;
        $uploadedPath = null;
        $resumeWasUploaded = false;

        if (!empty($resumeId)) {
            $selectedResume = $user->resumes()->where('id', $resumeId)->first();

            if (!$selectedResume) {
                return back()->withErrors(['resume_id' => 'The selected resume is invalid.']);
            }
        }

        try {
            if (empty($resumeId) && $request->hasFile('resume_file')) {
                $file = $request->file('resume_file');
                $uploadedPath = Storage::disk('cloud')->putFile('resumes', $file);

                if (!$uploadedPath) {
                    throw new \RuntimeException('Cloud upload failed: empty storage path returned.');
                }

                $selectedResume = new Resume([
                    'filename'       => $file->getClientOriginalName(),
                    'fileUrl'        => $uploadedPath,
                    'contactDetails' => '',
                    'education'      => '',
                    'experience'     => '',
                    'skills'         => '',
                    'summary'        => '',
                    'userId'         => $user->id,
                ]);
                $resumeWasUploaded = true;
            }

            if (!$selectedResume) {
                throw new \RuntimeException('No resume was resolved for this application.');
            }

            $extractedResumeData = $this->resumeAnalysisService->extractResumeInformation($selectedResume->fileUrl);

            Log::info('Resume analysis result.', [
                'user_id' => $user->id,
                'job_id' => $job->id,
                'resume_path' => $selectedResume->fileUrl,
                'analysis' => $extractedResumeData,
            ]);

            DB::transaction(function () use ($user, $job, $selectedResume, $resumeWasUploaded, $extractedResumeData, &$resumeId) {
                if ($resumeWasUploaded) {
                    $selectedResume->save();
                }

                $selectedResume->fill([
                    'education' => $extractedResumeData['education'],
                    'experience' => $extractedResumeData['experience'],
                    'skills' => $extractedResumeData['skills'],
                    'summary' => $extractedResumeData['summary'],
                ]);
                $selectedResume->save();

                $resumeId = $selectedResume->id;

                JobApplication::create([
                    'userId'       => $user->id,
                    'jobVacancyId' => $job->id,
                    'resumeId'     => $resumeId,
                    'status'       => 'pending',
                ]);
            });
        } catch (Throwable $e) {
            if ($uploadedPath) {
                Storage::disk('cloud')->delete($uploadedPath);
            }

            Log::error('Job application submission failed during resume upload or analysis.', [
                'user_id' => $user?->id,
                'job_id' => $job?->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['resume_file' => 'We could not process your resume. Please try again.']);
        }

        return redirect()->route('job-applications.index')
                         ->with('success', 'Application submitted successfully!');
    }



        public function testGroqApi()
    {
        try {
            $apiKey = env('GROQ_API_KEY');
            
            if (!$apiKey) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'GROQ_API_KEY not found in .env file'
                ], 400);
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'       => 'llama-3.3-70b-versatile',
                'messages'    => [
                    [
                        'role'    => 'user',
                        'content' => "Hello, respond with 'GROQ API is working!'"
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens'  => 100,
            ]);

            if ($response->failed()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'API request failed',
                    'details' => $response->json()
                ], $response->status());
            }

            $data = $response->json();
            $aiResponse = $data['choices'][0]['message']['content'] ?? 'No response content';

            return response()->json([
                'status'   => 'success',
                'message'  => 'GROQ API is working',
                'response' => $aiResponse,
                'full_data'=> $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Exception occurred',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
