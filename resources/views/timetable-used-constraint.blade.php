<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Timetable {$timetable->id} Used Constraints") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="font-semibold p-4">
                    {{ __('Lecture Slot Constraint') }}
                </h3>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Day') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Start At') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('End At') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lecture_slot_constraints as $lecture_slot_constraint)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $lecture_slot_constraint->lectureSlotConstraint->day->day }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecture_slot_constraint->lectureSlotConstraint->start_at }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecture_slot_constraint->lectureSlotConstraint->end_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h3 class="font-semibold p-4">
                    {{ __('Lecturer Constraint') }}
                </h3>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Lecturer Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Lecture Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Day') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Start At') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('End At') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lecturer_constraints as $lecturer_constraint)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $lecturer_constraint->lecturerConstraint->lecturer->lecturer_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecturer_constraint->lecturerConstraint->lecture->course->course_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecturer_constraint->lecturerConstraint->day->day ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecturer_constraint->lecturerConstraint->start_at ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecturer_constraint->lecturerConstraint->end_at ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
