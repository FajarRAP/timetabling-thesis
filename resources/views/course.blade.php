<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <x-primary-button class="self-end" x-data x-on:click.prevent="$dispatch('open-modal', 'add-course')">
                {{ __('Add Course') }}
            </x-primary-button>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <form action="{{ url()->current() }}" method="GET">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Course Name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Credit Hour') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Is Has Practicum') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Is Online') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Is Even Semester') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                        {{ __('Filter') }}</td>
                                    <td class="px-6 py-3"></td>
                                    <td class="px-6 py-3">
                                        <x-select-input class="text-sm font-normal" name="credit_hour"
                                            onchange="this.form.submit()">
                                            <x-slot name="options">
                                                <option value=""
                                                    {{ request()->query('credit_hour') ? '' : 'selected' }}>
                                                    {{ __('No Filter') }}</option>
                                                <option value="2"
                                                    {{ request()->query('credit_hour') == 2 ? 'selected' : '' }}>
                                                    2
                                                </option>
                                                <option value="3"
                                                    {{ request()->query('credit_hour') == 3 ? 'selected' : '' }}>
                                                    3
                                                </option>
                                            </x-slot>
                                        </x-select-input>
                                    </td>
                                    <td class="px-6 py-3">
                                        <x-select-input class="text-sm font-normal" name="is_has_practicum"
                                            onchange="this.form.submit()">
                                            <x-slot name="options">
                                                <option value=""
                                                    {{ request()->query('is_has_practicum') ? '' : 'selected' }}>
                                                    {{ __('No Filter') }}</option>
                                                <option value="is_has_practicum"
                                                    {{ request()->query('is_has_practicum') == 'is_has_practicum' ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                                <option value="is_not_has_practicum"
                                                    {{ request()->query('is_has_practicum') == 'is_not_has_practicum' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </x-slot>
                                        </x-select-input>
                                    </td>
                                    <td class="px-6 py-3">
                                        <x-select-input class="text-sm font-normal" name="is_online"
                                            onchange="this.form.submit()">
                                            <x-slot name="options">
                                                <option value=""
                                                    {{ request()->query('is_online') ? '' : 'selected' }}>
                                                    {{ __('No Filter') }}</option>
                                                <option value="is_online"
                                                    {{ request()->query('is_online') == 'is_online' ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                                <option value="is_not_online"
                                                    {{ request()->query('is_online') == 'is_not_online' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </x-slot>
                                        </x-select-input>
                                    </td>
                                    <td class="px-6 py-3">
                                        <x-select-input class="text-sm font-normal" name="is_even_semester"
                                            onchange="this.form.submit()">
                                            <x-slot name="options">
                                                <option value=""
                                                    {{ request()->query('is_even_semester') ? '' : 'selected' }}>
                                                    {{ __('No Filter') }}</option>
                                                <option value="is_even_semester"
                                                    {{ request()->query('is_even_semester') == 'is_even_semester' ? 'selected' : '' }}>
                                                    Yes
                                                </option>
                                                <option value="is_not_even_semester"
                                                    {{ request()->query('is_even_semester') == 'is_not_even_semester' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </x-slot>
                                        </x-select-input>
                                    </td>
                                    <td class="px-6 py-3"></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courses as $course)
                                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $loop->index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $course->course_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $course->credit_hour }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-text-input type="checkbox" class="checked:text-indigo-500"
                                                :disabled="true" :checked="$course->is_has_practicum" />
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-text-input type="checkbox" class="checked:text-indigo-500"
                                                :disabled="true" :checked="$course->is_online" />
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-text-input type="checkbox" class="checked:text-indigo-500"
                                                :disabled="true" :checked="$course->is_even_semester" />
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-danger-button x-data
                                                x-on:click.prevent="$dispatch('open-modal', 'delete-course-{{ $course->id }}')">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                            <x-delete-data-modal :action="route('course.destroy', $course)"
                                                name="delete-course-{{ $course->id }}" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                    {{ $courses->links('components.pagination.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-course" :show="$errors->addCourse->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('course.store') }}" class="p-6">
            @csrf
            @method('POST')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add Course') }}
            </h2>

            <div class="mt-6">
                <x-input-label for="course_name" value="{{ __('Course Name') }}" />
                <x-text-input id="course_name" name="course_name" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Course Name') }}" />
                <x-input-error :messages="$errors->addCourse->get('course_name')" />
            </div>
            <div class="mt-6">
                <x-input-label for="credit_hour" value="{{ __('Credit Hour') }}" />
                <x-text-input id="credit_hour" name="credit_hour" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Credit Hour') }}" />
                <x-input-error :messages="$errors->addCourse->get('credit_hour')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Course') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
