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
    Schema::create('applications', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('event_id')->unsigned();
      $table->bigInteger('user_id')->unsigned();
      $table->date('apply_date');
      $table->boolean('is_paid');
      $table->timestamps();

      // イベントが削除されたら申込みも削除する
      $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('applications');
  }
};
