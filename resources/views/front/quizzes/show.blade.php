<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Quiz: {{ $quiz->title }}
        </h2>
    </x-slot>

    <x-slot name="title">
        {{ $quiz->title }}
    </x-slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (!$quiz->public && !auth()->check())
                        <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-red-700">
                            <span class="inline-block align-middle mr-8">
                                 Bài kiểm tra này chỉ dành cho thành viên <a href="{{ route('login') }}"
                                                                             class="hover:underline">ĐĂNG NHẬP</a> hoặc <a
                                    href="{{ route('register') }}"
                                    class="hover:underline"> ĐĂNG KÝ</a>
                            </span>
                        </div>
                    @else
                        @livewire('front.quizzes.show', [
                        'quiz' => $quiz ,
                        'questions' => $questions,
                        'test'=> $test,
                        'minutesLeft' => $minutesLeft,
                        'secondsLeft' => $secondsLeft,
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
