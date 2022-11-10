<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Create 5 users in the database
        User::factory(5)->create();
        //Factory Relationship of Company and Contact - There will be 50 companies and has 5 contacts
        Company::factory(50)->hasContacts(5)->create();
        // Contact::factory(100)->create();
    }
}
