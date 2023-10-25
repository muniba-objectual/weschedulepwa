<?php

namespace App\Http\Livewire\Qb;

use App\Models\ExpenseCategory;
use Livewire\Component;

class ItemCategoryList extends Component
{
    public function render()
    {
        return <<<'blade'
            <div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>QB Account Number</th>
                        <th>QB Account Name</th>
                        <th>In Use</th>
                        <th>Display Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Models\ExpenseCategory::all() as $itemCategory)
                        <tr>
                            <td>{{ $itemCategory->id }}</td>
                            <td>{{ $itemCategory->qb_account_name }}</td>
                            <td>
                                <input type="checkbox" wire:click="toggleIsActive({{$itemCategory->id}})" {{ $itemCategory->is_active ? 'checked' : '' }}>
                            </td>
                            <td>{{ $itemCategory->name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        blade;
    }

    public function toggleIsActive(ExpenseCategory $itemCategory){
        $itemCategory->update([
            'is_active' => ! $itemCategory->is_active,
        ]);
    }


}
