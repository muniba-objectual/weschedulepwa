<div wire:poll.active id="timelineData" class="container-fluid">
    <p>The following Children have not had a Privacy Visit:</p>

    @foreach ($grouped as $monthYear => $CMs)
        <span class="bg-success">{{$monthYear}}</span>

        <br/><br/>
        <div class="row">

            @foreach ($CMs as $CMAsString => $children)

                <div class="col-3">
                    @php($CM = json_decode($CMAsString,false))

                    @if ($CM)
                        <u>Case Manager:</u> <a href="/users/{{$CM->id}}">{{$CM->name}}</a>
                    @else
                        <u>Case Manager:</u> N/A
                    @endif

                    <ul>
                        @foreach ($children as $child)
                            <li><a href="/children/{{$child->id}}">{{$child->initials}}</a></li>
                        @endforeach
                    </ul>
                    
                </div>
            @endforeach
        </div>
        <br/>
    @endforeach
</div>



