<?php

namespace App\Http\Controllers\API\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactFormRequest as Request;
use App\Services\ContactsServiceImpl as ContactsService;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ContactsService::getAllContacts();
    }

    /**
     * Store or update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contactData = $request->only('id','name','surname','phone','email','status');
        $contactData['image'] = $request->file('image');
        return ContactsService::storeContact($contactData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ContactsService::get($id);
    }

    /**
     * Store or update resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $contactData = $request->only('id','name','surname','phone','email','status');
        $contactData['image'] = $request->file('image');
        return ContactsService::updateContact($id,$contactData);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return ContactsService::deleteContact($id);
    }
}
