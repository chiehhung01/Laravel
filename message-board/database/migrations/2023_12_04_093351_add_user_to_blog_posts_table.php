<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // $table->unsignedInteger('user_id')->nullable();           
            
           
            if( env('DB_CONNECTION')=== 'sqlite_testing'){
                $table->unsignedInteger('user_id')->default(0);
            }else{
                $table->unsignedInteger('user_id');
            }
            
             $table->foreign('user_id')->references('id')->on('users');
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
             $table->dropForeign(['user_id']);
             $table->dropColumn('user_id');
        });
    }
};
