<div>
    <table class="table table-responsive" style="width: 100%;">
        <tr>
            <th style="text-align: center;">Pending</th>
            <th style="text-align: center;">Verified</th>
            <th style="text-align: center;">Paid Out</th>
        </tr>
        @foreach($collection as $fkUserId => $group)
            <tr>
                @if($group['stage']==1)
                @elseif($group['stage']==2)
                    <td></td>
                @elseif($group['stage']==3)
                    <td></td>
                    <td></td>
                @endif

                <td>
                    <div>
                        @unless($group['stage']==1)
                            <a class="btn btn-info" wire:click="updateStage('{{$fkUserId}}', '{{$group['stage']-1}}')" href="#">&lt;</a>
                        @endunless

                        <span class="btn btn-outline-info">
                            {{$group['user']->name}} &nbsp;&nbsp;
                            <span class="badge-danger">{{$group['unverified']}}</span>
                            &nbsp;
                            <span class="badge-warning ba">{{$group['verified']}}</span>
                            &nbsp;
                            <span class="badge-success">{{$group['paid']}}</span>
                        </span>

                        @unless($group['stage']==3)
                            <a class="btn btn-info" wire:click="updateStage('{{$fkUserId}}', '{{$group['stage']+1}}')" href="#">&gt;</a>
                        @endunless
                    </div>

                    <div>
                        <p>
                        </p>
                    </div>
                </td>

                @if($group['stage']==1)
                    <td></td>
                    <td></td>
                @elseif($group['stage']==2)
                    <td></td>
                @elseif($group['stage']==3)
                @endif
            </tr>
        @endforeach
    </table>
</div>
