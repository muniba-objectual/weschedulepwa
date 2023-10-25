<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
});

//Broadcast::channel('IR', function ($user) {
//    if (auth()->check()) {
//       $tmpUser['name'] = $user->name;
//       $tmpUser['id'] = $user->id;
//
//
//       return $tmpUser;
//
////        return [
////            'name' => $user->name,
////            'id' => $user->id,
////            ];
//    };
//
////    return ['name' => $user->name];
//}
//);

Broadcast::channel('IR.{id}', function ($user) {
    if (auth()->check()) {
        $tmpUser['name'] = $user->name;
        $tmpUser['id'] = $user->id;


        return $tmpUser;

//        return [
//            'name' => $user->name,
//            'id' => $user->id,
//            ];
    };

//    return ['name' => $user->name];
}
);
//Broadcast::channel('private-IR', function ($user) {
//    return $user;
//});

Broadcast::channel('private-IR.{id}', function ($user) {
    return $user;
});
