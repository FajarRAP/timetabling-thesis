<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lecturer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <x-primary-button class="self-end" x-data x-on:click.prevent="$dispatch('open-modal', 'add-lecturer')">
                {{ __('Add Lecturer') }}
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
                                    {{ __('Lecturer Number') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Lecturer Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lecturers as $lecturer)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $lecturer->lecturer_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $lecturer->lecturer_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-danger-button x-data
                                            x-on:click="$dispatch('open-modal', 'delete-lecturer-{{ $lecturer->id }}')">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                        <x-delete-data-modal :action="route('lecturer.destroy', $lecturer)"
                                            name="delete-lecturer-{{ $lecturer->id }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $lecturers->links('components.pagination.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-lecturer" :show="$errors->addLecturer->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('lecturer.store') }}" class="p-6">
            @csrf
            @method('POST')

            <div class="mt-6">
                <x-input-label for="lecturer_number" value="{{ __('Lecturer Number') }}" />
                <x-text-input id="lecturer_number" name="lecturer_number" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Lecturer Number') }}" />
                <x-input-error :messages="$errors->addLecturer->get('lecturer_number')" />
            </div>
            <div class="mt-6">
                <x-input-label for="lecturer_name" value="{{ __('Lecturer Name') }}" />
                <x-text-input id="lecturer_name" name="lecturer_name" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('lecturer Name') }}" />
                <x-input-error :messages="$errors->addLecturer->get('lecturer_name')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Lecturer') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
