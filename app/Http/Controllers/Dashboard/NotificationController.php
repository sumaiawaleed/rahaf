<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $data['notifications'] = Notification::when($request->user_id, function ($q) use ($request) {

            return $q->where('user_id', $request->user_id);

        })
            ->where('is_deleted', 0)
            ->latest('id')
            ->paginate(20);
        if ($request->ajax()) {
            if ($request->page == 0) {
                return view('dashboard.notifications._data', compact('data'))->render();
            } else {
                return view('dashboard.notifications._pagination_data', compact('data'))->render();
            }
        } else {
            $data['title'] = __('site.notifications');
            return view('dashboard.notifications.index', compact('data'));
        }
    }

    public function create(Request $request)
    {
        $data['title'] = __('site.add_notifications');
        $data['user_id'] = $request->user_id;
        $data['page_msg'] = __('site.data_added_successfully');
        return view('dashboard.notifications.create', compact('data', 'notifications'));
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
            'title' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {


            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        }

        $request_data['user_id'] = $request->user_id;
        $request_data['is_deleted'] = 0;
        $request_data['title'] = $request->title;
        $request_data['message'] = $request->message;

        $f = Notification::create($request_data);

        return response()->json(array('success' => true), 200);

    }

    public function edit(Notification $notification)
    {
        $data['title'] = __('site.edit_notifications');
        $data['page_msg'] = __('site.data_updated_successfully');

        return view('dashboard.notifications.edit', compact('data', 'notifications'));
    }

    public function update(Request $request, Notification $notification)
    {
        $rules = [
            'user_id' => 'required|integer',
            'title' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {


            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        }

        $request_data['user_id'] = $request->user_id;
        $request_data['is_deleted'] = 0;
        $request_data['title'] = $request->title;
        $request_data['message'] = $request->message;

        $notification->update($request_data);

        return response()->json(array('success' => true), 200);
    }

    public function destroy(Notification $notification)
    {
        $data['is_deleted'] = 1;

        $f = $notification->update($data);

        return response()->json(array('success' => true), 200);
    }

    public function archive(Request $request)
    {
        $data['notifications'] = Notification::when($request->user_id, function ($q) use ($request) {

            return $q->where('user_id', $request->user_id);

        })
            ->where('is_deleted', 0)
            ->latest('id')
            ->paginate(20);
        if ($request->ajax()) {
            if ($request->page == 0) {
                return view('dashboard.notifications._data', compact('data'))->render();
            } else {
                return view('dashboard.notifications._pagination_data', compact('data'))->render();
            }

        } else {
            $data['title'] = __('site.notifications');
            return view('dashboard.notifications.archive', compact('data'));
        }
    }

    public function restore(Request $request)
    {
        $notifications = Notification::find($request->notification_id);
        $data['is_deleted'] = 0;
        $w = new WelcomeController();
        $w->add_log('restore', 'notifications');
        $f = $notifications->update($data);
        return response()->json(array('success' => false), 200);
    }
}
