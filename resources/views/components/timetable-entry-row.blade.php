@props(['index', 'timetable_entry'])

<tr
    {{ $attributes->class(['border-b border-gray-200', 'bg-red-600 hover:bg-red-100 hover:text-gray-700 text-white' => $timetable_entry->is_hard_violated, 'bg-white hover:bg-gray-50' => !$timetable_entry->is_hard_violated]) }}>
    <th scope="row"
        {{ $attributes->class(['px-6 py-4 font-medium whitespace-nowrap', 'text-gray-50' => $timetable_entry->is_hard_violated, 'text-gray-900' => !$timetable_entry->is_hard_violated]) }}>
        {{ $index }}
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
