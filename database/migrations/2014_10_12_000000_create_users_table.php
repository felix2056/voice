<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('email')->unique()->nullable();
      $table->string('slug');
      $table->string('provider')->nullable();
      $table->string('provider_id')->nullable();
      $table->string('password');
      $table->string('avatar')->default('avatar.png');
      $table->timestamp('email_verified_at')->nullable();
      $table->datetime('last_login_at')->nullable();
      $table->string('last_login_ip')->nullable();
      $table->string('phonenumber');
      $table->string('street')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('postalcode')->nullable();
      $table->text('bio')->nullable();
      $table->string('country')->nullable();
      $table->softDeletes();
      $table->unsignedBigInteger('created_by')->nullable();
      $table->unsignedBigInteger('updated_by')->nullable();
      $table->unsignedBigInteger('deleted_by')->nullable();      
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
