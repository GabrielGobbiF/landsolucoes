<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VehicleActivities;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $archiveds = [];
        $trasheds = [];
        $read = [];

        $user = Auth::user();

        $unreadNotifications = $user->unreadNotifications;

        $readNotification = $user->readNotifications;

        foreach ($readNotification as $notification) {

            if ($notification->archived == 'Y') {
                $archiveds[] = $notification;
            } else if ($notification->deleted_at != '') {
                $trasheds[] = $notification;
            } else {
                $read[] = $notification;
            }
        }

        return view('pages.painel.notifications.index', [
            'readNotifications' => $read,
            'unreadNotifications' => $unreadNotifications,
            'archiveds' => $archiveds,
            'trasheds' => $trasheds,
        ]);
    }

    /**
     * Read Notification
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request, $uid)
    {
        $user = Auth::user();

        $notification = $user->notifications()->find($uid);

        $notification->markAsRead();

        if ($request->input('type') == 'json') {
            return response([], 200);
        }

        if ($notification->data['link'] != '') {
            return redirect($notification->data['link']);
        } else {
            return redirect()->route('notification');
        }
    }

    /**
     * Read All By User Notification
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function readAll()
    {
        $unreadNotifications = Auth::user()->unreadNotifications;

        $unreadNotifications->each(function ($notification) {
            $notification->markAsRead();
        });

        return redirect()->back();
    }

    /**
     * Archived Notification
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archived(Request $request, $uid)
    {
        $user = Auth::user();

        if (!$notification = $user->notifications()->find($uid)) {
            return redirect()
                ->route('notification')
                ->with('message', 'Registro não encontrado!');
        }

        $notification->archived = 'Y';
        $notification->save();
        $notification->update();

        return redirect()
            ->route('notification')
            ->with('message', 'Arquivada com sucesso!');
    }

    /**
     * Deleted Notification
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleted(Request $request, $uid)
    {
        $user = Auth::user();

        if (!$notification = $user->notifications()->find($uid)) {
            return redirect()
                ->route('notification')
                ->with('message', 'Registro não encontrado!');
        }

        $notification->archived = 'N';
        $notification->deleted_at = date('Y-m-d H:i:s');
        $notification->save();
        $notification->update();

        return redirect()
            ->route('notification')
            ->with('message', 'Deletada com sucesso!');
    }

    public function notifyUsersTest()
    {
        $text = 'oi';
        $user = Auth::user();
        $user->notify(new SendNotification($text));
    }

    private function notifyUsers($players, $text)
    {
        $players->each->notify(new SendNotification($text));
    }
}
