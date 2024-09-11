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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            
            $table->text('review');
            $table->unsignedTinyInteger('rating');
            //無符號小整數
            // unsignedTinyInteger 是 Laravel 中用於數據庫遷移的數據類型之一。
            //這個數據類型用於存儲無符號的 8 位整數，範圍是 0 到 255
            $table->timestamps();

            // $table->unsignedBigInteger('book_id');
            ////unsignedBigInteger。這確保這個列只能存儲無符號的 64 位整數
            // $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            // //onDelete('cascade'):刪除圖書book其相關評論review也跟著刪除

            //foreign key
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            //->constrained()：定義外鍵約束，表示 book_id 列參考 books 表格的 id 列。
            // ->cascadeOnDelete()：設定外鍵約束，在 books 表格中刪除相應的行時，與之關聯的 reviews 表格中的行也會被自動刪除。

            // constrained() 方法預期外鍵的名稱遵循特定的命名規則。在這個情況下，它預期外鍵的名稱為 {表格名}_id_foreign。
            // 例如，如果你有一個 books 表格，那麼 Laravel 將預期與 book_id 列相關的外鍵約束的名稱為 books_id_foreign。
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
