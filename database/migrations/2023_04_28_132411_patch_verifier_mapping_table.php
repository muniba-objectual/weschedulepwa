<?php

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
        $invalidUserId = \DB::table('users')
            ->whereNot(function($q){ return $q
                ->whereBetween('user_type', ['3.0', '6.0'])
                ->orWhere('user_type', '10.0');
            })->pluck('id');

        \DB::table('expenses_verifiers')->whereIn('verifier_user_id', $invalidUserId)->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
