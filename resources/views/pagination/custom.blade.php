@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between w-full">

        {{-- Tampilan Mobile (Simpel) --}}
        <div class="flex justify-between flex-1 sm:hidden gap-2">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-default leading-5 rounded-lg">
                    &laquo; Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[#0f392b] bg-white border border-gray-300 leading-5 rounded-lg hover:bg-[#0f392b] hover:text-[#c5a059] transition shadow-sm">
                    &laquo; Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[#0f392b] bg-white border border-gray-300 leading-5 rounded-lg hover:bg-[#0f392b] hover:text-[#c5a059] transition shadow-sm">
                    Selanjutnya &raquo;
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-default leading-5 rounded-lg">
                    Selanjutnya &raquo;
                </span>
            @endif
        </div>

        {{-- Tampilan Desktop (Lengkap) --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            {{-- Info Jumlah Data --}}
            <div>
                <p class="text-sm text-gray-500">
                    Menampilkan <span class="font-bold text-[#0f392b]">{{ $paginator->firstItem() }}</span> sampai <span
                        class="font-bold text-[#0f392b]">{{ $paginator->lastItem() }}</span> dari <span
                        class="font-bold text-[#0f392b]">{{ $paginator->total() }}</span> hasil
                </p>
            </div>

            {{-- Tombol Navigasi --}}
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-xl">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span
                                class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200 cursor-default rounded-l-xl leading-5"
                                aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-l-xl leading-5 hover:text-[#c5a059] hover:bg-[#0f392b] hover:border-[#0f392b] transition focus:z-10 focus:outline-none active:bg-gray-100 active:text-gray-700"
                            aria-label="@lang('pagination.previous')">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-200 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-[#c5a059] bg-[#0f392b] border border-[#0f392b] cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-200 leading-5 hover:bg-gray-50 hover:text-[#0f392b] focus:z-10 focus:outline-none transition"
                                        aria-label="@lang('pagination.goto_page', ['page' => $page])">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-r-xl leading-5 hover:text-[#c5a059] hover:bg-[#0f392b] hover:border-[#0f392b] transition focus:z-10 focus:outline-none active:bg-gray-100 active:text-gray-700"
                            aria-label="@lang('pagination.next')">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span
                                class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-300 bg-white border border-gray-200 cursor-default rounded-r-xl leading-5"
                                aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 11 7.293 7.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
