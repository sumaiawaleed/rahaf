<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    //
    public function index()
    {
        $g = new HomeController();
        $data['title'] = __('site.contact');
        $data['general'] = $g->get_general();
        return view('pages.contactUS',compact('data'));
    }

    /** * Show the application dashboard. * * @return \Illuminate\Http\Response */
    public function send(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);




        //#######################################################
        //فحص الـ spam حيث تم عمل حقلين داخل form واحد فيه بيانات والاخر فارغ
        //#######################################################
        $check_result = false;
        $check_name_of_sender = $request->input('name_of_sender');      //هذا فيه بيانات
        $check_age_of_sender = $request->input('age_of_sender');        //وهذا فارغ
        if($check_name_of_sender !=''){  //اذا كان فيه بيانات
            if($check_name_of_sender ==$request->input('_token')){
                //ضروري الحقل الذي فيه بيانات يكون القيمة حقه نفس القيمة التي في _token

                if($check_age_of_sender ==''){//اذا كان فارغ
                    $check_result = true; //تنجح العملية
                }
            }
        }
        if($check_result != true){
            //اذا كان فحص الحقول الخاصة بـ spam خطأ فانه يوهم المستخدم انه تم ارسال الرسالة بنجاح
            $data['msg'] = __('validation.success_send_contactus');
            $data['success'] = TRUE;
            return json_encode($data);
        }
        //#######################################################


        $sendername = $request->input('name');
        $senderemail = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');


        if ($senderemail !=''){$senderemail = trim($senderemail);}
        $senderemail = strtolower($senderemail);




        $message = 'from: '.$sendername.' \r\n'.
            'email :'.$senderemail.' \r\n'.
            'subject: '.$subject.' \r\n'.
            'message: '.$message;

        $message = str_replace('\r\n', PHP_EOL, $message);


        ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );

        $from = $senderemail;
        $to = "sumaia20waleed@gmail.com";
        $headers = "From:". $from . "\r\n";


        $success = mail($to,$subject,$message,$headers);

        if ($success) {
            $data['msg'] = __('validation.success_send_contactus');
            $data['success'] = TRUE;
            return json_encode($data);

        }else{
            $data['msg'] = __('validation.failure_send_contactus');
            $data['success'] = FALSE;
            return json_encode($data);

        }
    }
}
