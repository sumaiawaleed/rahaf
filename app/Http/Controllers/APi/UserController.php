<?php

namespace App\Http\Controllers\APi;

use App\Ad;
use App\Contacts;
use App\Functions\ApiHelper;
use App\Http\Controllers\Controller;
use App\User;
use App\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        unset($user->is_deleted);
        unset($user->email_verified_at);
        $user->gender = ( $user->gender != 1) ? "ذكر" :  ($user->gender != 2 ? "أنثى" : "");
        $data['user'] = $user;

        $apis = new ApiHelper();
        $apis->createApiResponse(false, 200, "", $data);
        return;
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $rules = [
            'name' => 'required|string',
            'phone_number' => 'required|string|',
            'address' => 'required|string',
            'email' => [Rule::unique('users')->ignore($user->id, 'id'), 'required', 'string', 'email'],
        ];



        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $apis = new ApiHelper();
            $apis->createApiResponse(true, 200, "validation error", "");
            return;
        } else {
            $data['name'] = $request->name;
            $data['phone_number'] = $request->phone_number;
            $data['address'] = $request->address;
            $data['email'] = $request->email;
            $data['gender'] = $request->gender;

            $user->update($data);

            $apis = new ApiHelper();
            $apis->createApiResponse(true, 200, "تم التحديث بنجاح", $user);
            return;
        }
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $apis = new ApiHelper();
            $apis->createApiResponse(true, 200, "validation error", "");
            return;
        } else {
            $user = User::find($request->user()->id);

            if (Hash::check($request->old_password, $user->password)) {
                $data['password'] = bcrypt($request->password);
                $user->update($data);
                $apis = new ApiHelper();
                $apis->createApiResponse(false, 200, "تم تغيير كلمة المرور بنجاح", "");
                return;
            } else {
                $apis = new ApiHelper();
                $apis->createApiResponse(true, 200, "  كلمة المرور السابقة غير مطابقة", "");
                return;
            }
        }
    }

    public function contacts(Request $request)
    {
        $user = $request->user();
        $data['contacts'] = Contacts::all();
        foreach ($data['contacts'] as $s) {
            $s->name = $s->getTranslateName('ar');
            $s->type = $s->get_type($s->type);
            $s->icon_path = $s->getImageSize(30, 30);
            $s->user = UserContact::where('user_id', $user->id)
                ->where('contact_id', $s->id)->first();
            unset($s->icon);

        }
        $apis = new ApiHelper();
        $apis->createApiResponse(true, 200, "", $data);
        return;
    }

    public function update_contact(Request $request)
    {
        $user = $request->user();
        try {
            $contacts = json_decode($request->contacts, TRUE);

            foreach ($contacts as $s) {
                $contact = Contacts::find($s['contact_id']);
                if ($contact) {
                    $data['user_id'] = $user->id;
                    $data['contact_id'] = $s['contact_id'];
                    $data['value'] = $s['contact_value'];
                    $data['is_visible'] = $s['is_visible'];


                    $user_contact = UserContact::where('contact_id', $s['contact_id'])
                        ->where('user_id', $user->id)->first();


                    if ($user_contact) {
                        $user_contact->update($data);
                    } else {
                        UserContact::create($data);
                    }
                }
            }
            $apis = new ApiHelper();
            $apis->createApiResponse(false, 200, "تم تعديل البيانات بنجاح", "");
            return;
        } catch (\Exception $ex) {
            $apis = new ApiHelper();
            $apis->createApiResponse(true, 404, "NOT FOUND", "");
            return;
        }
    }
}
