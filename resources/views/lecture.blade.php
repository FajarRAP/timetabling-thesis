<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lecture') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <x-primary-button class="self-end" x-data x-on:click.prevent="$dispatch('open-modal', 'add-lecture')">
                {{ __('Add Lecture') }}
            </x-primary-button>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Lecture Course Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Lecture Lecturer Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Lecture Class') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lectures as $lecture)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $lecture->course->course_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecture->lecturer->lecturer_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecture->class }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-danger-button x-data
                                            x-on:click="$dispatch('open-modal', 'delete-lecture-{{ $lecture->id }}')">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                        <x-delete-data-modal :action="route('lecture.destroy', $lecture)"
                                            name="delete-lecture-{{ $lecture->id }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $lectures->links('components.pagination.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-lecture" :show="$errors->addLecture->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('lecture.store') }}" class="p-6">
            @csrf
            @method('POST')

            <div class="mt-6">
                <x-input-label for="course_id" value="{{ __('Select Course') }}" />
                <x-select-input name="course_id" id="course_id" class="mt-1 block w-3/4">
                    <x-slot:options>
                        <option value="" disabled selected>{{ __('Select Course') }}</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </x-slot:options>
                </x-select-input>
                <x-input-error :messages="$errors->addLecture->get('course_id')" />
            </div>
            <div class="mt-6">
                <x-input-label for="lecturer_id" value="{{ __('Select Lecturer') }}" />
                <x-select-input name="lecturer_id" id="lecturer_id" class="mt-1 block w-3/4">
                    <x-slot:options>
                        <option value="" disabled selected>{{ __('Select Lecturer') }}</option>
                        @foreach ($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}">{{ $lecturer->lecturer_name }}</option>
                        @endforeach
                    </x-slot:options>
                </x-select-input>
                <x-input-error :messages="$errors->addLecture->get('lecturer_id')" />
            </div>
            <div class="mt-6">
                <x-input-label for="class" value="{{ __('Class') }}" />
                <x-text-input id="class" name="class" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Class') }}" />
                <x-input-error :messages="$errors->addLecture->get('class')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Lecture') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
