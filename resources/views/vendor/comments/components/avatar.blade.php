@php
    //$defaultAvatar = 'https://www.gravatar.com/avatar/unknown?d=mp';

    $defaultAvatar = '/img/default-avatar.png';

    if ($user = auth()->user()) {
        //$segment = md5(strtolower($user->name));
        //if ($user->profile_pic)
        if ($user->profile_pic)
            //$defaultAvatar = "/" . $user->profile_pic;
            $defaultAvatar = "/storage/" . substr($user->profile_pic, 7);
        } else {

            //$defaultAvatar = "https://www.gravatar.com/avatar/{$segment}?d=mp";
        $defaultAvatar = '/img/default-avatar.png';
    }


@endphp




<img
    class="comments-avatar"
    src="{{ isset($comment) &&  $comment->commentatorProperties() ? $comment->commentatorProperties()->avatar : $defaultAvatar }}"
    alt="avatar"
>

