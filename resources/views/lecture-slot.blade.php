<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lecture Slot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <div class="flex gap-3 justify-end">
                <x-secondary-button x-data x-on:click.prevent="$dispatch('open-modal', 'show-constraint')">
                    {{ __('Show Constraint') }}
                </x-secondary-button>
                <x-primary-button x-data x-on:click.prevent="$dispatch('open-modal', 'add-constraint')">
                    {{ __('Add Constraint') }}
                </x-primary-button>

            </div>

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
                                        {{ __('Day') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Time Slot') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Room Class') }}
                                    </th>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                        {{ __('Filter') }}</td>
                                    <td class="px-6 py-3">
                                        <x-select-input class="text-sm font-normal" name="day"
                                            onchange="this.form.submit()">
                                            <x-slot name="options">
                                                <option value="" {{ request()->query('day') ? '' : 'selected' }}>
                                                    {{ __('No Filter') }}</option>
                                                @foreach ($days as $day)
                                                    <option value="{{ $day->id }}"
                                                        {{ request()->query('day') == $day->id ? 'selected' : '' }}>
                                                        {{ $day->day }}
                                                    </option>
                                                @endforeach
                                            </x-slot>
                                        </x-select-input>
                                    </td>
                                    <td class="px-6 py-3">
                                        <x-select-input class="text-sm font-normal" name="time_slot"
                                            onchange="this.form.submit()">
                                            <x-slot name="options">
                                                <option value="" {{ request()->query('day') ? '' : 'selected' }}>
                                                    {{ __('No Filter') }}</option>
                                                @foreach ($time_slots as $time_slot)
                                                    <option value="{{ $time_slot->id }}"
                                                        {{ request()->query('time_slot') == $time_slot->id ? 'selected' : '' }}>
                                                        {{ $time_slot->time_slot }}
                                                    </option>
                                                @endforeach
                                            </x-slot>
                                        </x-select-input>
                                    </td>
                                    <td class="px-6 py-3">
                                        <x-select-input class="text-sm font-normal" name="room_class"
                                            onchange="this.form.submit()">
                                            <x-slot name="options">
                                                <option value="" {{ request()->query('day') ? '' : 'selected' }}>
                                                    {{ __('No Filter') }}</option>
                                                @foreach ($room_classes as $room_class)
                                                    <option value="{{ $room_class->id }}"
                                                        {{ request()->query('room_class') == $room_class->id ? 'selected' : '' }}>
                                                        {{ $room_class->room_class }}
                                                    </option>
                                                @endforeach
                                            </x-slot>
                                        </x-select-input>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lecture_slots as $lecture_slot)
                                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $loop->index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $lecture_slot->day->day }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $lecture_slot->timeSlot->time_slot }}
                                        </td>
                                        <td class="px-6 py-4 flex flex-col gap-2">
                                            {{ $lecture_slot->roomClass->room_class }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>

                    {{ $lecture_slots->links('components.pagination.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-constraint" :show="$errors->addLectureSlotConstraint->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('lecture-slot-constraint.store') }}" class="p-6">
            @csrf
            @method('POST')

            <div class="mt-6">
                <x-input-label for="day" value="{{ __('Day') }}" />
                <x-select-input name="day" id="day" class="mt-1 block w-3/4">
                    <x-slot name="options">
                        <option value="" disabled {{ old('day') ? '' : 'selected' }}>{{ __('Select Day') }}
                        </option>
                        @foreach ($days as $day)
                            <option value="{{ $day->id }}" {{ old('day') == $day->id ? 'selected' : '' }}>
                                {{ $day->day }}
                            </option>
                        @endforeach
                    </x-slot>
                </x-select-input>
                <x-input-error :messages="$errors->addLectureSlotConstraint->get('day')" />
            </div>
            <div class="mt-6">
                <x-input-label for="start_at" value="{{ __('Start At') }}" />
                <x-text-input type="time" id="start_at" name="start_at" class="mt-1 block w-3/4"
                    placeholder="{{ __('Start At') }}" :value="old('start_at')" />
                <x-input-error :messages="$errors->addLectureSlotConstraint->get('start_at')" />
            </div>
            <div class="mt-6">
                <x-input-label for="end_at" value="{{ __('End At') }}" />
                <x-text-input type="time" id="end_at" name="end_at" class="mt-1 block w-3/4"
                    placeholder="{{ __('End At') }}" :value="old('end_at')" />
                <x-input-error :messages="$errors->addLectureSlotConstraint->get('end_at')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Constraint') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <x-modal name="show-constraint">
        <div class="p-6 space-y-6">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lecture Slot Constraint') }}
            </h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                #
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
                            <th scope="col" class="px-6 py-3">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lecture_slot_constraints as $constraint)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $loop->index + 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $constraint->day->day }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $constraint->start_at }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $constraint->end_at }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('lecture-slot-constraint.destroy', $constraint) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button>
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-modal>
</x-app-layout>
