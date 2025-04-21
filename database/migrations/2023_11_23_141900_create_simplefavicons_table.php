<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreatesimplefaviconsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::dropIfExists('simplefavicons');
    Schema::create('simplefavicons', function (Blueprint $table) {
      $table->id();
      $table->timestamp('timestamp')->useCurrent()->onUpdate(null);
      
      $table->string('status')->nullable();

      $table->string('file_path')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('simplefavicons');
  }
}