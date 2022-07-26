<?php

namespace App\Services;

use App\Http\Resources\ContactResource;
use App\Models\Contact;

class ContactsServiceImpl implements ContactsService {

    public static function getAllContacts()
    {
        try{
            $contacts = Contact::with('media')->orderBy('name','ASC')->get();
            return ContactResource::collection($contacts);
        }catch(\Exception $exception){
            return [
                'message' => 'Error fetching contacts.',
                'code' => 500,
                'data' => [
                    'exception' => $exception
                ]
            ];
        }
    }

    public static function get($id)
    {

        try{
            $contact = Contact::with('media')->findOrFail($id);
            return new ContactResource($contact);
        }catch(\Exception $exception){
            return [
                'message' => 'Contact not found.',
                'code' => 404,
                'data' => []
            ];
        }
    }

    public static function storeContact($data)
    {

        try{
            $contactData = $data;
            unset($contactData['image']);

            $contact = Contact::create($contactData);

            if($data['image'] != null){
                if(isset($contact->media[0])){
                    $contact->media[0]->delete();
                }
                $contact->addMedia($data['image'])->toMediaCollection('contactImages');
            }
            return new ContactResource($contact);
        }catch(\Exception $exception){
            return [
                'message' => 'Error creating contact.',
                'code' => 500,
                'data' => [
                    'exception' => $exception
                ]
            ];
        }
    }

    public static function updateContact($id,$data)
    {

        try{
            $contactData = $data;
            unset($contactData['image']);

            $contact = Contact::with('media')->findOrFail($id);
            $contact->update($contactData);
            if($data['image'] != null){
                if(isset($contact->media[0])){
                    $contact->media[0]->delete();
                }
                $contact->addMedia($data['image'])->toMediaCollection('contactImages');
            }
            return new ContactResource($contact);
        }catch(\Exception $exception){
            return [
                'message' => 'Error creating contact.',
                'code' => 500,
                'data' => [
                    'exception' => $exception
                ]
            ];
        }
    }

    public static function deleteContact($id)
    {
        $contact = Contact::with('media')->findOrFail($id);
        if(isset($contact->media[0])){
            $contact->media[0]->delete();
        }
        $contact->delete();
        return $contact;
    }
}
