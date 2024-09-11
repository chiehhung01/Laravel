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
        Schema::table('comments', function (Blueprint $table) {
            if( env('DB_CONNECTION') !== 'sqlite_testing'){
                $table->dropForeign(['blog_post_id']);              
            //表示当关联的 blog_posts 表中的记录被删除时，相应的 comments 表中的记录也会被级联删除
            }      
            $table->foreign('blog_post_id')
            ->references('id')->on('blog_posts')->onDelete('cascade');     
         
        });
    }    
    //up 方法：删除现有外键，添加一个新的外键，並指定级联删除。

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['blog_post_id']);
            $table->foreign('blog_post_id')
            ->references('id')->on('blog_posts');                      
        });
    }
    // down 方法：删除现有外键，重新添加一个外键，没有指定级联删除。
};
