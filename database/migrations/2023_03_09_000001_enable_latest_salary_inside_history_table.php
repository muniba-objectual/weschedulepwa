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
        Schema::table('users_children_history', function (Blueprint $table) {
            $table->integer('updated_by')->unsigned()->after('user_id')->nullable()->change();
            $table->integer('assigned_by')->unsigned()->after('updated_by');
            $table->timestamp('expired_at')->nullable()->after('created_at');
        });
        Schema::table('users_children_history', function (Blueprint $table) {
            $table->renameColumn('updated_by', 'unassigned_by');
        });

//        foreach (\DB::table('users_children_history')->get() as $history){
//            \DB::table('users_children_history')->where('id', $history->id)->update([
//                'expired_at' => $history->created_at,
//                'assigned_by' => $history->unassigned_by,
//            ]);
//        }
//        foreach (\DB::table('users_children')->get() as $activeSalaryInstance){
//
//            $activeSalInHistory = \DB::table('users_children_history')
//                ->where([
//                    'child_id' => $activeSalaryInstance->children_id,
//                    'user_id' => $activeSalaryInstance->users_id,
//                ])->whereNull('expired_at')
//                ->first();
//
//            if($activeSalInHistory)
//            {
//                \DB::table('users_children_history')
//                    ->where('id', $activeSalInHistory->id)
//                    ->update([
//                        'child_id'      => $activeSalaryInstance->children_id,
//                        'user_id'       => $activeSalaryInstance->users_id,
//                        'salary'        => $activeSalaryInstance->salary,
//                        'assigned_by'   => 1,
//                    ]);
//            }else{
//                \DB::table('users_children_history')
//                    ->insert([
//                        'child_id'      => $activeSalaryInstance->children_id,
//                        'user_id'       => $activeSalaryInstance->users_id,
//                        'salary'        => $activeSalaryInstance->salary,
//                        'assigned_by'   => 1,
//                    ]);
//            }
//        }

        \DB::table('users_children_history')->truncate();
        foreach (\DB::table('users_children')->get() as $activeSalaryInstance) {

            \DB::table('users_children_history')
                ->insert([
                    'child_id'      => $activeSalaryInstance->children_id,
                    'user_id'       => $activeSalaryInstance->users_id,
                    'salary'        => $activeSalaryInstance->salary,
                    'assigned_by'   => $activeSalaryInstance->updated_by,
                    'updated_at'    => $activeSalaryInstance->updated_at,
                    'created_at'    => $activeSalaryInstance->created_at,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_children_history', function (Blueprint $table) {
            $table->renameColumn('unassigned_by', 'updated_by');
            $table->dropColumn('assigned_by');
            $table->dropColumn('expired_at');
        });

    }
};
