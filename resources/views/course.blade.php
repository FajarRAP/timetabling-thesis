<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <x-primary-button class="self-end" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-course')">
                {{ __('Add Course') }}
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
                                    {{ __('Course Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Credit Hour') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $course->course_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $course->credit_hour }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-danger-button data-url="{{ route('course.destroy', ['course' => $course]) }}"
                                            class="delete-item-button">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-course" focusable>
        <form id="form" method="POST" action="{{ route('course.store') }}" class="p-6">
            @csrf
            @method('POST')

            <div class="mt-6">
                <x-input-label for="course_name" value="{{ __('Course Name') }}" />
                <x-text-input id="course_name" name="course_name" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Course Name') }}" />
                <x-input-error-ajax class="input-error course_name" />
            </div>
            <div class="mt-6">
                <x-input-label for="credit_hour" value="{{ __('Credit Hour') }}" />
                <x-text-input id="credit_hour" name="credit_hour" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Credit Hour') }}" />
                <x-input-error-ajax class="input-error credit_hour" />
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

    @push('scripts')
        <script src="../assets/main.js"></script>
        <script>
            deleteItemAJAX();
            createItemAJAX();
        </script>
    @endpush
</x-app-layout>
