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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id')->nullable()->default(0);
            $table->bigInteger('subscription_id')->nullable()->default(0);
            $table->string('name')->nullable()->default(null);
            $table->string('last_name')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('phone_no', 250)->unique();
            $table->string('adderss', 250)->nullable()->default(null);
            $table->string('city', 250)->nullable()->default(null);//
            $table->string('zip_code', 250)->nullable()->default(null);//
            $table->string('state', 250)->nullable()->default(null);//
            $table->string('password',250)->nullable()->default(null);
            $table->string('access_token', 50)->nullable()->default(null);
            $table->boolean('get_notification')->default(1);
            $table->softDeletes();
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
};
