@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:center;gap:5px;flex-wrap:wrap;padding:4px 0">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span style="padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid #d4ead9;color:#b0c8ba;background:#fff;cursor:not-allowed;display:inline-flex;align-items:center;gap:5px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            Sebelumnya
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           style="padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid #d4ead9;color:#3d5c49;background:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s"
           onmouseover="this.style.borderColor='#2d8653';this.style.color='#1a4731'"
           onmouseout="this.style.borderColor='#d4ead9';this.style.color='#3d5c49'">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            Sebelumnya
        </a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:7px 10px;font-size:13px;font-weight:700;color:#7a9585;">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="padding:7px 13px;border-radius:8px;font-size:13px;font-weight:800;border:1.5px solid #2d8653;background:#2d8653;color:#fff;display:inline-block;">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       style="padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid #d4ead9;color:#3d5c49;background:#fff;text-decoration:none;display:inline-block;transition:all .18s"
                       onmouseover="this.style.borderColor='#2d8653';this.style.color='#1a4731'"
                       onmouseout="this.style.borderColor='#d4ead9';this.style.color='#3d5c49'">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           style="padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid #d4ead9;color:#3d5c49;background:#fff;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s"
           onmouseover="this.style.borderColor='#2d8653';this.style.color='#1a4731'"
           onmouseout="this.style.borderColor='#d4ead9';this.style.color='#3d5c49'">
            Berikutnya
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>
    @else
        <span style="padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid #d4ead9;color:#b0c8ba;background:#fff;cursor:not-allowed;display:inline-flex;align-items:center;gap:5px;">
            Berikutnya
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </span>
    @endif

</nav>
@endif
