<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-gray-950 via-black to-gray-950 py-12">
        <div class="max-w-6xl mx-auto px-4">

            <!-- Back Button -->
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 mb-8 transition">
                ← Back to Jobs
            </a>

            <!-- Main Content -->
            <div class="grid lg:grid-cols-3 gap-8">

                <!-- Left Column - Job Details -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Job Header Card -->
                    <div class="bg-gray-900/80 backdrop-blur border border-gray-800 rounded-2xl p-8 hover:border-gray-700 transition">
                        <h1 class="text-4xl font-bold text-white mb-3">{{ $job->title }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-3 mb-6 text-white/70">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                {{ $job->company->name ?? 'Unknown Company' }}
                            </span>
                            <span class="text-gray-700">•</span>
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $job->location }}
                            </span>
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 bg-indigo-500/20 border border-indigo-500/50 text-indigo-300 px-4 py-2 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 100-4V6a4 4 0 00-4-4H8a4 4 0 00-4 4v12a2 2 0 100 4v-2a4 4 0 01-4-4V6z"></path>
                                </svg>
                                {{ $job->type }}
                            </span>
                            <span class="inline-flex items-center gap-2 bg-purple-500/20 border border-purple-500/50 text-purple-300 px-4 py-2 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06m0 0L4.25 13m12.5-12.5L15.75 13m-9.5 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                {{ $job->jobcategory->name ?? 'N/A' }}
                            </span>
                            <span class="inline-flex items-center gap-2 bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-2 rounded-full text-sm font-medium">
                                {{ $job->viewCount ?? 0 }} Views
                            </span>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="bg-gray-900/80 backdrop-blur border border-gray-800 rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H6a6 6 0 016 6v3h3a1 1 0 11 0 2h-.22l1.123 2.246A1 1 0 1315.5 16H4.75A2.75 2.75 0 012 13.25v-2.5A2.25 2.25 0 014 8.5h2V5z" clip-rule="evenodd"></path>
                            </svg>
                            Job Description
                        </h2>
                        <div class="text-white/80 leading-relaxed space-y-4">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Requirements -->
                    @if($job->requirements)
                    <div class="bg-gray-900/80 backdrop-blur border border-gray-800 rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.002v2.947c0 1.993-1.679 3.615-3.712 3.92-1.231.228-2.367.455-3.312.455-1.945 0-3.03-1.114-3.743-2.251C2.874 10.487 2 9.306 2 8.404v-2.947a3.066 3.066 0 012.267-3.002z" clip-rule="evenodd"></path>
                            </svg>
                            Requirements
                        </h2>
                        <div class="text-white/80 leading-relaxed space-y-4">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Right Column - Sidebar -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Salary Card -->
                    <div class="bg-gradient-to-br from-green-900/40 to-green-800/20 border border-green-700/50 rounded-2xl p-6">
                        <p class="text-green-300 text-sm font-medium mb-2">Annual Salary</p>
                        <p class="text-3xl font-bold text-green-400">${{ number_format($job->salary) }}</p>
                        <p class="text-green-300/70 text-sm mt-2">/ year</p>
                    </div>

                    <!-- Job Info Card -->
                    <div class="bg-gray-900/80 backdrop-blur border border-gray-800 rounded-2xl p-6 space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-start justify-between">
                                <span class="text-white/60 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 6V2a2 2 0 012-2h4a2 2 0 012 2v4h4a2 2 0 012 2v4a2 2 0 01-2 2h-4v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H2a2 2 0 01-2-2V8a2 2 0 012-2h4z"></path>
                                    </svg>
                                    Job Type
                                </span>
                                <span class="text-white font-medium">{{ $job->type }}</span>
                            </div>

                            <div class="h-px bg-gray-800"></div>

                            <div class="flex items-start justify-between">
                                <span class="text-white/60 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06m0 0L4.25 13m12.5-12.5L15.75 13m-9.5 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Category
                                </span>
                                <span class="text-white font-medium">{{ $job->jobcategory->name ?? 'N/A' }}</span>
                            </div>

                            <div class="h-px bg-gray-800"></div>

                            <div class="flex items-start justify-between">
                                <span class="text-white/60 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Location
                                </span>
                                <span class="text-white font-medium">{{ $job->location }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Company Info -->
                    @if($job->company)
                    <div class="bg-gray-900/80 backdrop-blur border border-gray-800 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            About Company
                        </h3>

                        <p class="text-white font-semibold text-base mb-3">{{ $job->company->name }}</p>
                        
                        @if($job->company->industry)
                        <p class="text-white/60 text-sm mb-2">
                            💼 {{ $job->company->industry }}
                        </p>
                        @endif

                        @if($job->company->address)
                        <p class="text-white/60 text-sm mb-3">
                            📍 {{ $job->company->address }}
                        </p>
                        @endif

                        @if($job->company->website)
                        <a href="{{ $job->company->website }}" target="_blank" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition text-sm font-medium">
                            Visit Website →
                        </a>
                        @endif
                    </div>
                    @endif

                    <!-- Apply Button -->
                    <a href="{{ route('job.apply', $job->id) }}" class="block w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-2xl p-6 text-center transition transform hover:scale-105 shadow-lg hover:shadow-indigo-500/50">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3.954-7.908A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM5 16a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Apply Now
                        </span>
                    </a>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
