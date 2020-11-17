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
            $table->string('date_length')->nullable()->comment('时长');
            $table->string('work_end_date')->nullable()->comment('交付日期');
            $table->text('xuqiu')->nullable()->comment('需求');
            $table->string('jindu')->nullable()->comment('进度');
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
