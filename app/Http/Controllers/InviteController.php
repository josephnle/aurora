<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Mail\Invitation;
use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('viewAll', Invite::class);
    	$invites = Invite::all();
	    return view( 'invite/index', compact( 'invites' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $this->authorize('create', Invite::class);
	    return view('invite/create');
    }

    public function createConfirm(Request $request)
    {
	    $emails = str_replace(' ', '', $request->input('emails'));  // Remove spaces
	    $emails = explode("\r\n", $emails);                         // Convert to array
	    $emails = array_unique($emails);                            // Remove duplicates

	    $email_count = count($emails);

	    // Validate emails
	    $errors = [];
	    foreach ($emails as $email) {
		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    $errors[] = "{$email} is not a valid email!";
		    }
	    }

	    if (count($errors) > 0) {
		    return redirect()->back()->withInput()->withErrors($errors);
	    }

    	return view('invite/createConfirm', compact('emails', 'email_count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Invite::class);

        $emails = $request->input('emails');

	    // Validate emails
	    foreach ($emails as $email) {
		    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    abort(500, 'Invalid emails submitted!');
		    }
	    }

	    // Create invites
	    foreach ($emails as $email) {
	    	// Create invite
	    	$invite = Invite::create(['email' => $email]);

		    // Send invitation
		    Mail::to($email)->queue(new Invitation($invite));
	    }

	    $email_count = count($emails);

	    return redirect()->action('InviteController@index')->withMessage("Send invitations to {$email_count} emails");
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
}
