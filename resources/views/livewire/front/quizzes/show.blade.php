<div x-data="{
        minutesLeft: {{ $minutesLeft }},
        secondsLeft: {{$secondsLeft}},
        timeDisplay() {
            return `${this.minutesLeft.toString().padStart(2, '0')} phút ${this.secondsLeft.toString().padStart(2, '0')} giây`;
        }
    }"
     x-init="setInterval(() => {
        if (secondsLeft > 1) {
            secondsLeft--;
        } else {
            if (minutesLeft > 1) {
                minutesLeft--;
                secondsLeft = 60;
            }
            if(secondsLeft <= 0){
             $wire.submit();
            }
        }
    }, 1000);" class="w-full flex h-fit" id="quiz-content">
    <div class="max-w-7xl">
        <div class="divide-y">
            @foreach($questions as $question)
                {{--        {{ dd($question->text) }}--}}
                <div class="py-3" id="question-{{ $question->id }}">
                    <h2 class="mb-4 text-2xl">
                        <span><b>Câu hỏi {{$currentQuestionsIndex++}}:</b></span>{{ $question['text'] }}</h2>

                    @if ($question['code_snippet'])
                        <pre class="mb-4 border-2 border-solid bg-gray-50 p-2">{{ $question['code_snippet']}}</pre>
                    @endif
                    <div class="mb-3">
                        @foreach ($question['options'] as $option)
                            <div>
                                <label for="option.{{ $option['id'] }}">
                                    <input type="radio" id="option.{{ $option['id'] }}"
                                           wire:model="answersOfQuestions.{{ $question['id'] }}"
                                           value="{{ $option['id'] }}" class="mr-2"
                                    >
                                    {{ $option['text'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    <div class="w-[60%] h-screen" id="sidebar-question">
        <div class="sticky top-2 ml-2">
            <div class="mb-2 mt-3">
                Thời gian làm bài còn lại: <span x-text="timeDisplay()" class="font-bold"></span>.
            </div>
            <div class="flex-wrap flex">
                @foreach($questions as $question)
                    <div class="p-2 w-fit h-fit">
                        <a href="#question-{{ $question->id }}"
                           class="block border border-gray-300 p-2 rounded-lg {{ isset($answersOfQuestions[$question->id]) ? 'bg-red-500 text-white' : '' }}">
                            Câu hỏi {{ $loop->iteration }}
                        </a>
                    </div>
                @endforeach
            </div>
            <p class="mt-1 text-sm text-gray-600">
                Bạn không thể nộp bài nếu chưa trả lời hết các câu hỏi.
            </p>
            <button
                {{count($answersOfQuestions) < $questions->count() ? 'disabled' : ''}}
                class="block border p-2 rounded-lg bg-green-400 my-2 text-white" wire:click="submit()">
                Nộp bài
            </button>
        </div>
    </div>
    <script>
        function updateHeight() {
            var content = document.getElementById('quiz-content');
            var sidebar = document.getElementById('sidebar-question');
            sidebar.style.height = content.offsetHeight + 'px';
        }

        document.addEventListener('DOMContentLoaded', updateHeight);
        document.addEventListener('livewire:update', updateHeight);
    </script>
</div>
