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
        //pre-admissioin data
        $records = \DB::table('temp_form_data')->where('form', 'pre-admissions')->get();

        foreach ($records as $record){
            $data = (array) json_decode($record->raw_data, true);

            //records not having the created_by data but still having the edited_by data.
            if( !isset($data['created_by']['id']) && isset($data['edited_by']['id']) ){

                $data['created_by']['id'] = $data['edited_by']['id'];

                if( !isset($data['edited_by']['name']) ){
                    //derive from user table.
                    $user = \DB::table('users')->where('id', $data['edited_by']['id'])->first();
                    $data['created_by']['name'] = $user->name ?? 'Unknown';
                }else{
                    $data['created_by']['name'] = $data['edited_by']['name'];
                }
            }
        }
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
