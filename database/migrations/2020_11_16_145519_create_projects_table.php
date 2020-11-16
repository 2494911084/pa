<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');
            $table->string('mininame')->nullable()->comment('简称');
            $table->string('work_start_date')->nullable()->comment('开始时间');
            $table->string('work_end_date')->nullable()->comment('结束时间');
            $table->string('status')->default(0)->comment('状态0进行中1已完成');
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
        Schema::dropIfExists('projects');
    }
}
