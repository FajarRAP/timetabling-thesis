<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Timetable {$timetable->id} Entries") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            @foreach ($timetable_entries_by_room_class as $room_class => $timetable_entries)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="font-semibold p-4">
                        {{ __('Room Class') }}
                        {{ $room_class }}
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
                                        {{ __('Time Slot') }}
                                    </th>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Lecture Course Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Lecture Lecturer Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Class') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timetable_entries as $timetable_entry)
                                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $loop->index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $timetable_entry->lectureSlot->day->day }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $timetable_entry->lectureSlot->timeSlot->time_slot }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ __($timetable_entry->lecture->course->course_name) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ __($timetable_entry->lecture->lecturer->lecturer_name) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ __($timetable_entry->lecture->class) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
