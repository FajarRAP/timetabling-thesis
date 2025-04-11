<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Room Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <x-primary-button class="self-end" x-data x-on:click.prevent="$dispatch('open-modal', 'add-room-class')">
                {{ __('Add Room Class') }}
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
                                    {{ __('Room Class') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomClasses as $roomClass)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $roomClass->room_class }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-danger-button x-data
                                            x-on:click="$dispatch('open-modal', 'delete-room-class-{{ $roomClass->id }}')">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                        <x-delete-data-modal :action="route('room-class.destroy', $roomClass)"
                                            name="delete-room-class-{{ $roomClass->id }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $roomClasses->links('components.pagination.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-room-class" :show="$errors->addRoomClass->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('room-class.store') }}" class="p-6">
            @csrf
            @method('POST')

            <div class="mt-6">
                <x-input-label for="room_class" value="{{ __('Room Class') }}" />

                <x-text-input id="room_class" name="room_class" type="text" class="mt-1 block w-3/4"
                    placeholder="{{ __('Room Class Name') }}" />

                <x-input-error :messages="$errors->addRoomClass->get('room_class')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Room Class') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
