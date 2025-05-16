@props(['name', 'action'])

<x-modal :$name focusable>
    <form method="POST" action="{{ $action }}">
        @csrf
        @method('DELETE')

        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this data?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button type="button" x-data x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button type="submit" class="ms-3">
                    {{ __('Delete Data') }}
                </x-danger-button>
            </div>
        </div>
    </form>
</x-modal>
