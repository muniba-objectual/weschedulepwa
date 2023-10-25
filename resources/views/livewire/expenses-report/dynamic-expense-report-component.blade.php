<?php /** @var \App\Models\Expenses $detail  */?>

<div wire:poll.active id="timelineData" class="timeline timeline-inverse ">

    @if($this->optimizedMode)

        @foreach($virtualMonthNodes as $timestampData)
            <?php
                $key = $timestampData->created_at->format('M-Y');
            ?>

            <div class="time-label">
                <span class="bg-success" style="cursor: pointer;" wire:click="toggleExpandMonth('{{ $timestampData->created_at->format('Y-m') }}', '{{$key}}')">
                  {{$key}}
                </span>
            </div>

            @if( $this->timeline_data->has($key) )
                <?php $timeline = $this->timeline_data[$key]; ?>

                @include('livewire.expenses-report.grouped-item')

            @endif
        @endforeach
    @else
        @if ($this->timeline_data->count() > 0)
            @foreach ($this->timeline_data as $key => $timeline)

                <div class="time-label">
                    <span class="bg-success" style="cursor: pointer;" wire:click="toggleExpand('{{$key}}')">
                      {{$key}}
                    </span>
                </div>

                @include('livewire.expenses-report.grouped-item')

            @endforeach
        @endif
    @endif

    <div>
        <i class="far fa-clock bg-gray"></i>
    </div>

    <div class="timeline_pagination"> {{ $this->timeline_data->links() }}</div>

    <script>
        function deleteExpense($id) {
            alert ($id);
        }
    </script>
</div>
