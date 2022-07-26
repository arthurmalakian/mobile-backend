<?php

namespace App\Services;


interface ContactsService {
    public static function getAllContacts();
    public static function get($id);
    public static function storeContact($data);
    public static function updateContact($id,$data);
    public static function deleteContact($id);
}
