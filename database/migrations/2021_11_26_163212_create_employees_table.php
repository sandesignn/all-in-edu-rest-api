<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('name');
            $table->string('nik')->nullable();
            $table->string('no_kk')->nullable();
            $table->date('birth')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->enum('gender', ['male', 'female']);
            $table->string('religion')->nullable();
            $table->integer('salary')->nullable();
            $table->enum('marital_status', ['single', 'maried'])->nullable();
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
        Schema::dropIfExists('employees');
    }
}
