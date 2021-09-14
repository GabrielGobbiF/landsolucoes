<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
    public function show($uid)
    {
        $user = Auth::user();

        $notification = $user->notifications()->find($uid);

        $notification->markAsRead();

        if ($notification->data['link'] != '') {
            return redirect($notification->data['link']);
        } else {
            return redirect()->route('notifications.index');
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

        return redirect()->route('notifications.index');
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
                ->route('notifications.index')
                ->with('message', 'Registro não encontrado!');
        }

        $notification->archived = 'Y';
        $notification->save();
        $notification->update();

        return redirect()
            ->route('notifications.index')
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
                ->route('notifications.index')
                ->with('message', 'Registro não encontrado!');
        }

        $notification->archived = 'N';
        $notification->deleted_at = date('Y-m-d H:i:s');
        $notification->save();
        $notification->update();

        return redirect()
            ->route('notifications.index')
            ->with('message', 'Deletada com sucesso!');
    }
}
