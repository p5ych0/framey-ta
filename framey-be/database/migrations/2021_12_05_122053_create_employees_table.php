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
            $table->string('name', 40);
            $table->string('position', 20)->index();
            $table->unsignedBigInteger('superior')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->nestedSet();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('superior')->references('id')->on('employees')->nullOnDelete();
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
