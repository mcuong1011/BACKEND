<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h6 class="text-xl font-bold">Bài Kiểm tra</h6>
                    <div class="flex w-100 flex-wrap">
                        <table class="table mt-4 w-full table-view">
                            <thead>
                            <tr>
                                <th class="bg-gray-50 px-6 py-3 text-left w-1/2">
                                    <span
                                        class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Tên</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span
                                        class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Thời gian làm bài (Phút)</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span
                                        class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Số lượng câu hỏi</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span
                                        class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Trạng thái</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($registered_only_quizzes as $quiz)
                                <tr @class([
                                ])>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $quiz->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $quiz->limited_time }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $quiz->questions_count }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        @if ($test = $quiz->isDoneByUser(auth()->user()))
                                            <a href="{{ route('results.show', $test->id) }}"
                                               class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Đã
                                                làm</a>
                                        @elseif($quiz->needContinue(auth()->user()))
                                            <a href="{{ route('quiz.show', $quiz->slug) }}"
                                               class="text-red-600 underline underline-offset-4"><b>Tiếp tục làm</b></a>
                                        @else
                                            <a href="{{ route('quiz.show', $quiz->slug) }}"
                                               class="text-red-600 underline underline-offset-4"><b>Vào làm</b></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No Test.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h6 class="text-xl font-bold">Bài luyện tập</h6>
                    <div class="flex w-100 flex-wrap">
                        <table class="table mt-4 w-full table-view">
                            <thead>
                            <tr>
                                <th class="bg-gray-50 px-6 py-3 text-left w-1/2">
                                    <span
                                            class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Tên</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span
                                            class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Thời gian làm bài (Phút)</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span
                                            class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Số lượng câu hỏi</span>
                                </th>
                                <th class="bg-gray-50 px-6 py-3 text-left">
                                    <span
                                            class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Trạng thái</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($public_quizzes as $quiz)
                                <tr @class([
                                ])>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $quiz->title }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $quiz->limited_time }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        {{ $quiz->questions_count }}
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        @if ($test = $quiz->isDoneByUser(auth()->user()))
                                            <a href="{{ route('results.show', $test->id) }}"
                                               class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Đã
                                                làm</a>
                                        @elseif($quiz->needContinue(auth()->user()))
                                            <a href="{{ route('quiz.show', $quiz->slug) }}"
                                               class="text-red-600 underline underline-offset-4"><b>Tiếp tục làm</b></a>
                                        @else
                                            <a href="{{ route('quiz.show', $quiz->slug) }}"
                                               class="text-red-600 underline underline-offset-4"><b>Vào làm</b></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No Test.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
