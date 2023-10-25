<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       $ph = new User();
       $ph->id = 999;
       $ph->name = "PLACEHOLDER";
       $ph->email = "null@calendar.io";
       
       $ph->user_type = 0;
       
       $ph->password = "%!@!";
       $ph->fk_CaseManagerID = 0;
       $ph->save();
    }


};
