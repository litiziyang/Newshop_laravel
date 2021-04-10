<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->comment('名称');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('父级ID');
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->boolean('is_directory')->comment('是否拥有子类目');
            $table->unsignedBigInteger('level')->comment('当前类目层级');
            $table->string('path')->comment('该类目所有类目ID');
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
        Schema::dropIfExists('categories');
    }
}
