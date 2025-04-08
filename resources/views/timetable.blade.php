<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <x-primary-button class="self-end" x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-timetable')">
                {{ __('Add Timetable') }}
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
                                    {{ __('Fitness Score') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Created At') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timetables as $timetable)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $timetable->fitness_score ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->created_at }}
                                    </td>
                                    <td class="px-6 py-4 flex flex-col gap-2">
                                        @if (!$timetable->fitness_score)
                                            <x-primary-button data-timetableId="{{ $timetable->id }}"
                                                data-url="{{ route('timetable-entry.store') }}"
                                                class="generate-timetable {{ $timetable->id }} w-1/2 justify-center">
                                                {{ __('Generate') }}
                                            </x-primary-button>
                                        @endif
                                        <a href="{{ route('timetable-entry', ['timetable' => $timetable]) }}">
                                            <x-primary-button class="w-1/2 justify-center">
                                                {{ __('Show entries') }}
                                            </x-primary-button>
                                        </a>
                                        <x-danger-button
                                            data-url="{{ route('timetable.destroy', ['timetable' => $timetable]) }}"
                                            class="delete-item-button w-1/2 justify-center">
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

    <x-modal name="add-timetable">
        <form id="form" method="POST" action="{{ route('timetable.store') }}" class="p-6">
            @csrf
            @method('POST')

            <div class="mt-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Create New Timetable') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('After created please press generate timetable, to add timetable entries') }}
                </p>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Add Timetable') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    @push('scripts')
        <script src="../assets/main.js"></script>
        <script>
            createItemAJAX();
            deleteItemAJAX();

            const generateTimetableButtons = document.querySelectorAll('.generate-timetable');
            generateTimetableButtons.forEach(function(button) {
                button.addEventListener('click', async function(event) {
                    const timetableId = this.getAttribute('data-timetableId');
                    const url = this.getAttribute('data-url');

                    const response = await fetch(url, {
                        body: JSON.stringify({
                            timetable_id: timetableId
                        }),
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                        method: 'POST'
                    });

                    if (response.ok) window.location.reload();
                });
            });
        </script>
    @endpush
</x-app-layout>
