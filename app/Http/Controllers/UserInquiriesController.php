<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Inquiry;
use App\InquiryResponse;

use Redirect;
use Validator;
use Mail;
use Session;
use Auth;
use App\helpers\DatatableHandler;

class UserInquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.pages.inquiry');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function send_inquiry(Request $request){
        //validation here
        $rule = [
            "fullname" => "required",
            "email" => "required|email",
            "birthday" => "required|before:today",
            "address" => "max:1000",
            "questions" => "required|max:1000"
        ];

        $validator = Validator::make($request->all(),$rule);
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput($request->all());
        }

        $with_website_email = Mail::send('emails.pages.inquiry_thank_you', [ 'web_settings'=> [ 'thank-you-content' => '<h3>Thank you view.</h3>' ] ], function ($message) use($request) {
            $message->from('noreply@domain.ph', 'Domz Garcia');
            $message->to($request->input('email'))->subject('Thank you');
        });
        
        $hasRecipient = false;
        $recipients = 'dom.garcia@nuworks.ph;domgarciad@yahoo.com';
        
        if($hasRecipient){
            $mail_recipient = array_filter( explode( ";", $recipients ) );
            $data = $request->all();
            
            $with_recipient_email = Mail::send('emails.pages.inquiry_content', compact('data'), function ($message) use($mail_recipient) {
                $message->from('noreply@domain.ph', 'Domz Garcia');
                $message->to($mail_recipient)->subject('New Inquiry Content');
            });
        }
        
        $inquiry = new Inquiry();
        $inquiry->full_name = $request->input('fullname');
        $inquiry->email =$request->input('email');
        $inquiry->birthdate =$request->input('birthday');
        $inquiry->address =$request->input('address');
        $inquiry->question = $request->input('questions');
        $inquiry->is_active = 1;
        $inquiry->save();

        // if($return == 1 && $return_1 == count($mail_recipient)){
        // Session::flash('send_success', '1');
        // }

        Session::flash('send_success', '1');
        return Redirect::back();
    }

    public function render_mailer(){
        return view('cms.pages.user.mailer');   
    }

    public function get_inbox(Request $request){
        $customDataTable = new DatatableHandler($request, "inquiries");
        $data = $customDataTable->make();
        return $data;
    }

}
