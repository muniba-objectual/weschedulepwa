<?php
namespace App\InsertTypes;

use App\Models\User;
use Illuminate\Support\Str;
use WireElements\Pro\Components\Insert\InsertQueryResult;
use WireElements\Pro\Components\Insert\InsertQueryResults;
use WireElements\Pro\Components\Insert\Types\InsertType;

class UserInsert extends InsertType
{
    protected string $delimiter = '@';
    protected string $match = '\w{1,20}$';

    public function search($query): InsertQueryResults
    {
        return InsertQueryResults::make(
            User::query()
                ->where('name', 'like', "%{$query}%")

                    //                ->orWhere('handle', 'like', "%{$query}%")
                ->where('user_type','>=','3.0')
                ->where('user_type','<=','6.0')
                ->OrWhere('name', 'like', "%{$query}%")
                ->where('user_type','=','10.0')
                ->orderBy('name')
                ->get()
                ->map(function ($user) {
                    return InsertQueryResult::make(
                        id: $user->id,
                        headline: $user->name,
                        subheadline: '@' . str_replace(' ', '', $user->name),
                        photo: $user->profile_pic ? "/storage/" . substr($user->profile_pic,7) : sprintf('https://ui-avatars.com/api/?name=%s', urlencode($user->name)),
                        insert: '@' . str_replace(' ', '', $user->name),
                        // view: 'different-blade-file',
                    );
                }));
    }
}
