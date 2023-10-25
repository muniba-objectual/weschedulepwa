<?php

namespace App\Http\Controllers;


use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{

    /**
     * Get the new notification data for the navbar notification.
     *
     * @param Request $request
     * @return Array
     */
    public function getNotificationsData(Request $request)
    {
        // For the sake of simplicity, assume we have a variable called
        // $notifications with the unread notifications. Each notification
        // have the next properties:
        // icon: An icon for the notification.
        // text: A text for the notification.
        // time: The time since notification was created on the server.
        // At next, we define a hardcoded variable with the explained format,
        // but you can assume this data comes from a database query.

        $user = Auth::user();
        //get notifications for this user;
        $userExpenseNotifications = Notifications::where('fk_UserID','=',$user->id)->where('model','=','Expenses')->where('active','=','1')->get();
//        dd($userExpenseNotifications);

        $notifications = [
            [
                'icon' => 'fas fa-fw fa-receipt text-primary',
                'text' => count($userExpenseNotifications) . ' new receipt notifications',
                'time' => \Carbon\Carbon::parse($userExpenseNotifications->last()->created_at)->diffForHumans(),
            ],
//            [
//                'icon' => 'fas fa-fw fa-users text-primary',
//                'text' => rand(0, 10) . ' friend requests',
//                'time' => rand(0, 60) . ' minutes',
//            ],
//            [
//                'icon' => 'fas fa-fw fa-file text-danger',
//                'text' => rand(0, 10) . ' new reports',
//                'time' => rand(0, 60) . ' minutes',
//            ],
        ];

        // Now, we create the notification dropdown main content.

        $dropdownHtml = '';
        $url = url('/Expense/Report?show-notification-slider');

        foreach ($notifications as $key => $not) {
            $icon = "<i class='mr-2 {$not['icon']}'></i>";

            $time = "<span class='float-right text-muted text-sm'>
                   {$not['time']}
                 </span>";

            $dropdownHtml .= "<a href='{$url}' class='dropdown-item'>
                            {$icon}{$not['text']}{$time}
                          </a>";

            if ($key < count($notifications) - 1) {
                $dropdownHtml .= "<div class='dropdown-divider'></div>";
            }
        }

        // Return the new notification data.

        return [
            'label'       => count($notifications),
            'label_color' => 'danger',
            'icon_color'  => 'dark',
            'dropdown'    => $dropdownHtml,
        ];
    }

    public function getActionCenter(Request $request, $type) {
        $user = Auth::user();

        if ($type == 'Expenses') {
            return view('notifications.action-center.expenses', [
                'user' => $user,
                'subCategoryTitle' => 'Expenses'
            ]);
        }else{
            //TODO::ashain, keep adding future notifications!
            abort(404);
        }

    }

}
