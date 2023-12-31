<button type="button" wire:click.prefetch="sort('{{ $index }}')" class="btn btn-sm text-left text-sm">

    <span>
        {{ str_replace('_', ' ', $column['label']) }}
    </span>

    <span class="text-xs">
        @if($sort === $index)
            @if($direction)
                <span wire:loading.remove>
                    @include('datatables::icons.chevron-up')
                </span>
            @else
                <span wire:loading.remove>
                    @include('datatables::icons.chevron-down')
                </span>
            @endif
        @endif
    </span>
</button>
