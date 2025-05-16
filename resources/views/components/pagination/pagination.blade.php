<nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
    aria-label="Table navigation">
    <div class="flex flex-col gap-2 text-gray-700">
        <span class="text-sm font-medium">
            {{ __('Showing') }}
            @if ($paginator->firstItem())
                <span class="font-bold text-gray-900">{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</span>
            @endif
            {{ __('of') }}
            <span class="font-bold text-gray-900">{{ $paginator->total() }}</span>
        </span>
        <span class="text-sm font-medium flex gap-3 items-center">
            {{ __('Entries Per Page') }}
            <form action="{{ url()->current() }}" method="GET">
                <x-select-input name="per_page" onchange="this.form.submit()">
                    <x-slot name="options">
                        <option value="10" {{ request()->query('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="100"{{ request()->query('per_page') == 100 ? 'selected' : '' }}>100</option>
                        <option value="1000"{{ request()->query('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                    </x-slot>
                </x-select-input>
            </form>
        </span>
    </div>
    <ul class="inline-flex items-stretch -space-x-px">
        @php
            $prevUrl = $paginator->onFirstPage() ? null : $paginator->previousPageUrl();
            $nextUrl = !$paginator->hasMorePages() ? null : $paginator->nextPageUrl();
        @endphp

        <x-pagination.pagination-link :href="$prevUrl" class="rounded-l-lg">
            <x-svgs.arrow-left class="!text-gray-500 !size-3" />
        </x-pagination.pagination-link>

        @foreach ($elements as $element)
            @if ($element == '...')
                @continue
            @endif

            @foreach ($element as $page => $url)
                @php
                    $isActive = $page == $paginator->currentPage();
                @endphp

                @if ($paginator->currentPage() > 4 && $page === 2)
                    <x-pagination.pagination-link>
                        ...
                    </x-pagination.pagination-link>
                @endif

                @switch($page)
                    @case($paginator->currentPage())
                    @case($paginator->currentPage() - 1)

                    @case($paginator->currentPage() - 2)
                    @case($paginator->currentPage() + 1)

                    @case($paginator->currentPage() + 2)
                    @case($paginator->lastPage())

                    @case(1)
                        <x-pagination.pagination-link :href="$isActive ? null : $url" :$isActive>
                            {{ $page }}
                        </x-pagination.pagination-link>
                    @break

                    @default
                @endswitch

                @if ($paginator->currentPage() < $paginator->lastPage() - 3 && $page === $paginator->lastPage() - 1)
                    <x-pagination.pagination-link>
                        ...
                    </x-pagination.pagination-link>
                @endif
            @endforeach
        @endforeach

        <x-pagination.pagination-link :href="$nextUrl" class="rounded-r-lg">
            <x-svgs.arrow-right class="!text-gray-500 !size-3" />
        </x-pagination.pagination-link>
    </ul>
</nav>
