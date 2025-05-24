<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <x-primary-button class="self-end" x-data x-on:click.prevent="$dispatch('open-modal', 'add-timetable')">
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
                                    {{ __('Max Generation') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Stopped At Generation') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Population Size') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Mutation Rate') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Execution Times (Second)') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Hard Violations') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Soft Violations') }}
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
                                        {{ $timetable->max_generation ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->stopped_at_generation ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->population_size ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->mutation_rate ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->execution_times ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->hard_violations ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->soft_violations ?? __('Not yet generated') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $timetable->created_at }}
                                    </td>
                                    <td class="px-6 py-4 flex flex-col gap-2">
                                        @if (!$timetable->fitness_score)
                                            <x-primary-button class="w-full justify-center" x-data
                                                x-on:click="$dispatch('open-modal', 'generate-{{ $timetable->id }}')">
                                                {{ __('Generate') }}
                                            </x-primary-button>
                                            <x-modal name="generate-{{ $timetable->id }}" :show="$errors->generateEntries->isNotEmpty()" focusable>
                                                <form method="POST"
                                                    action="{{ route('timetable-entry.store', $timetable) }}"
                                                    class="p-6">
                                                    @csrf
                                                    @method('POST')

                                                    <h2 class="text-lg font-medium text-gray-900">
                                                        {{ __('Generate Timetable Entries') }}
                                                    </h2>

                                                    <div class="mt-6">
                                                        <x-input-label for="max_generation"
                                                            value="{{ __('Max Generation') }}" />
                                                        <x-text-input id="max_generation" name="max_generation"
                                                            type="number" class="mt-1 block w-3/4"
                                                            placeholder="{{ __('Max Generation (Default: 1)') }}"
                                                            :value="old('max_generation')" />
                                                        <x-input-error :messages="$errors->generateEntries->get('max_generation')" />
                                                    </div>
                                                    <div class="mt-6">
                                                        <x-input-label for="population_size"
                                                            value="{{ __('Population Size') }}" />
                                                        <x-text-input id="population_size" name="population_size"
                                                            type="number" class="mt-1 block w-3/4"
                                                            placeholder="{{ __('Population Size (Default: 5)') }}"
                                                            :value="old('population_size')" />
                                                        <x-input-error :messages="$errors->generateEntries->get('population_size')" />
                                                    </div>
                                                    <div class="mt-6">
                                                        <x-input-label for="mutation_rate"
                                                            value="{{ __('Mutation Rate') }}" />
                                                        <x-text-input id="mutation_rate" name="mutation_rate"
                                                            step="0.01" type="number" class="mt-1 block w-3/4"
                                                            placeholder="{{ __('Mutation Rate (Default: .2)') }}"
                                                            :value="old('mutation_rate')" />
                                                        <x-input-error :messages="$errors->generateEntries->get('mutation_rate')" />
                                                    </div>
                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            {{ __('Cancel') }}
                                                        </x-secondary-button>

                                                        <x-primary-button class="ms-3">
                                                            {{ __('Generate Timetable Entries') }}
                                                        </x-primary-button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        @endif
                                        <a href="{{ route('timetable-entry', $timetable) }}">
                                            <x-primary-button class="w-full justify-center">
                                                {{ __('Show entries') }}
                                            </x-primary-button>
                                        </a>
                                        @if ($timetable->fitness_score)
                                            <a href="{{ route('timetable-used-constraint.index', $timetable) }}">
                                                <x-primary-button class="w-full justify-center">
                                                    {{ __('Show Used Constraints') }}
                                                </x-primary-button>
                                            </a>
                                            <form action="{{ route('timetable.export', $timetable) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <x-primary-button class="w-full justify-center">
                                                    {{ __('Export to .xlsx') }}
                                                </x-primary-button>
                                            </form>
                                        @endif
                                        <x-danger-button class="w-full justify-center" x-data
                                            x-on:click="$dispatch('open-modal', 'delete-timetable-{{ $timetable->id }}')">
                                            {{ __('Delete') }}
                                        </x-danger-button>
                                        <x-delete-data-modal :action="route('timetable.destroy', $timetable)"
                                            name="delete-timetable-{{ $timetable->id }}" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $timetables->links('components.pagination.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-timetable" focusable>
        <form method="POST" action="{{ route('timetable.store') }}" class="p-6">
            @csrf
            @method('POST')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create New Timetable') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('After created please press generate timetable, to add timetable entries') }}
            </p>

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
</x-app-layout>
