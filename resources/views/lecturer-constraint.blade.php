<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("{$lecturer->lecturer_name}'s Constraints") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <form action="{{ route('lecturer-constraint.store', $lecturer) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('POST')

                <x-primary-button class="self-end">
                    {{ __('Apply Constraint') }}
                </x-primary-button>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Course Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Credit Hour') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Class') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Start At') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('End At') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Day') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $data = $constraints->isNotEmpty() ? $constraints : $lecturer->lectures;
                                @endphp

                                @foreach ($data as $index => $item)
                                    @php
                                        $lecture = $constraints->isNotEmpty() ? $item->lecture : $item;
                                        $dayId = $constraints->isNotEmpty() ? $item->day_id : null;
                                        $startAt = $constraints->isNotEmpty() ? $item->start_at : null;
                                        $endAt = $constraints->isNotEmpty() ? $item->end_at : null;
                                    @endphp

                                    <x-text-input type="hidden" name="constraints[{{ $index }}][lecturer_id]"
                                        :value="$lecturer->id" />
                                    <x-text-input type="hidden" name="constraints[{{ $index }}][lecture_id]"
                                        :value="$lecture->id" />

                                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $lecture->course->course_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $lecture->course->credit_hour }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $lecture->class }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-text-input type="time"
                                                name="constraints[{{ $index }}][start_at]" :value="$startAt" />
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-text-input type="time"
                                                name="constraints[{{ $index }}][end_at]" :value="$endAt" />
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-select-input name="constraints[{{ $index }}][day_id]"
                                                id="day">
                                                <x-slot name="options">
                                                    <option value="" disabled {{ $dayId ? '' : 'selected' }}>
                                                        {{ __('Select Day') }}</option>
                                                    @foreach ($days as $day)
                                                        <option value="{{ $day->id }}"
                                                            {{ $dayId == $day->id ? 'selected' : '' }}>
                                                            {{ $day->day }}
                                                        </option>
                                                    @endforeach
                                                </x-slot>
                                            </x-select-input>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
