<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-gray-950 via-black to-gray-950 py-12">
        <div class="max-w-2xl mx-auto px-4">

            <!-- Back Button -->
            <a href="{{ route('job.show', $job->id) }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 mb-8 transition">
                ← Back to Job
            </a>

            <!-- Main Card -->
            <div class="bg-gray-900/80 backdrop-blur border border-gray-800 rounded-2xl overflow-hidden">

                <!-- Header Section -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10">
                    <h1 class="text-3xl font-bold text-white mb-2">Apply for Position</h1>
                    <p class="text-white/90">{{ $job->title }} at {{ $job->company->name ?? 'Unknown' }}</p>
                </div>

                <!-- Content Section -->
                <div class="p-8 space-y-8">

                    <!-- Job Summary Card -->
                    <div class="border border-gray-700 rounded-xl p-6 bg-gray-800/50">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-white mb-2">{{ $job->title }}</h2>
                                <div class="flex flex-wrap gap-3 text-white/70 text-sm">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        {{ $job->company->name ?? 'Unknown' }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-green-400 font-bold text-lg">${{ number_format($job->salary) }}/year</p>
                                <p class="text-white/60 text-sm mt-1">{{ $job->type }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('job.apply.store', $job->id) }}" class="space-y-6">
                        @csrf

                        <!-- Resume Selection -->
                        <div class="space-y-3">
                            <label for="resume_id" class="block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                                </svg>
                                Select Your Resume
                            </label>
                            
                            @if($user->resumes && $user->resumes->count() > 0)
                                <select 
                                    id="resume_id" 
                                    name="resume_id" 
                                    required
                                    class="w-full bg-gray-800 text-white px-4 py-3 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                >
                                    <option value="">-- Choose a resume --</option>
                                    @foreach($user->resumes as $resume)
                                        <option value="{{ $resume->id }}">
                                            {{ $resume->filename ?? 'Resume' }} 
                                            @if($resume->created_at)
                                                ({{ $resume->created_at->diffForHumans() }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('resume_id')
                                    <p class="text-red-400 text-sm flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            @else
                                <div class="bg-yellow-900/20 border border-yellow-700 rounded-lg p-4">
                                    <p class="text-yellow-200 font-medium mb-3">📄 You don't have any resumes yet</p>
                                    <p class="text-yellow-300 text-sm mb-4">Please upload a resume to your profile before applying.</p>
                                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition font-medium">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        Go to Profile
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Cover Letter -->
                        <div class="space-y-3">
                            <label for="cover_letter" class="block text-sm font-semibold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                                </svg>
                                Cover Letter (Optional)
                            </label>
                            <textarea 
                                id="cover_letter" 
                                name="cover_letter" 
                                rows="5"
                                placeholder="Tell us why you're interested in this position and what makes you a great fit..."
                                class="w-full bg-gray-800 text-white px-4 py-3 rounded-lg border border-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-500 transition resize-none"
                            ></textarea>
                            <div class="flex justify-between items-center text-xs text-white/50">
                                <span>Share your motivation and relevant experience</span>
                                <span>Max 2000 characters</span>
                            </div>
                            @error('cover_letter')
                                <p class="text-red-400 text-sm flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Job Description Preview -->
                        @if($job->description)
                        <div class="border border-gray-700 rounded-lg p-4 bg-gray-800/50">
                            <h3 class="text-sm font-semibold text-white mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                </svg>
                                Job Description
                            </h3>
                            <p class="text-white/60 text-sm line-clamp-3">
                                {{ substr(strip_tags($job->description), 0, 200) }}{{strlen(strip_tags($job->description)) > 200 ? '...' : '' }}
                            </p>
                        </div>
                        @endif

                        <!-- Info Message -->
                        <div class="bg-indigo-900/20 border border-indigo-700/50 rounded-lg p-4">
                            <p class="text-indigo-200 text-sm flex gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span><strong>💡 Pro Tip:</strong> A tailored cover letter can significantly improve your chances. Highlight specific skills that match the job requirements.</span>
                            </p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4 pt-4">
                            <a 
                                href="{{ route('job.show', $job->id) }}" 
                                class="flex-1 px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-lg font-semibold text-center transition border border-gray-700"
                            >
                                Cancel
                            </a>
                            
                            @if($user->resumes && $user->resumes->count() > 0)
                                <button 
                                    type="submit" 
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-lg font-semibold transition transform hover:scale-105 shadow-lg hover:shadow-indigo-500/50"
                                >
                                    Submit Application
                                </button>
                            @else
                                <button 
                                    type="button" 
                                    disabled
                                    class="flex-1 px-6 py-3 bg-gray-700 text-gray-400 rounded-lg font-semibold cursor-not-allowed"
                                >
                                    Upload Resume First
                                </button>
                            @endif
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>