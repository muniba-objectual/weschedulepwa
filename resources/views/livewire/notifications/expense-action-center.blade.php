<div>
    <br><br>
    @if($collection->count())
        <table class="table table-responsive-sm">
            <tr>
                <th>Actions</th>
                <th>Datetime</th>
                <th>Sub Total</th>
                <th>HST</th>
                <th>Total</th>
            </tr>
            @foreach($collection as $expense)
                <tr>
                    <td>
                        @if( is_null($expense->expense_tab) )
                            <a class="btn btn-primary btn-sm" href='{{"/Expense/TemporaryExpenseShow/{$expense->id}"}}'>View Expense</a>
                        @else
                            @if($embeddedSlider && session('expense.report.active-tab') == $expense->expense_tab)
                                <a class="btn btn-primary btn-sm" href="#" onclick="focusToExpense({{$expense->id}}); Livewire.emit('slide-over.close');" title="Expense:{{$expense->id}}">View Expense</a>
                            @else
                                <a class="btn btn-primary btn-sm" href="/Expense/Report?tab_key={{$expense->expense_tab}}&focus-expense={{$expense->id}}" title="Expense:{{$expense->id}}">View Expense</a>
                            @endif
                        @endif
                        &nbsp;|&nbsp;
                        <a href="#" class="btn btn-outline-danger btn-sm" wire:click="dismiss({{$expense->id}})">Dismiss</a>
                    </td>
                    <td>{{$expense->datetime}}</td>
                    <td>{{$expense->subtotal}}</td>
                    <td>{{$expense->HST}}</td>
                    <td>{{$expense->total}}</td>
                </tr>
            @endforeach
        </table>
    @else
        <h5 style="text-align: center;font-style: italic;">You have no expenses notifications yet!</h5>
    @endif

</div>
