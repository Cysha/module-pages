<?php

use Illuminate\Database\Migrations\Migration;

class PagesCreateInitalTables extends Migration
{
    public function __construct()
    {
        // Get the prefix
        $this->prefix = config('cms.pages.config.table-prefix', 'pages_');
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        $prefix = $this->prefix;

        Schema::create($prefix.'pages', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('layout')->nullable()->default(null);
            $table->boolean('active')->default(false);

            $table->timestamps();
        });

        Schema::create($prefix.'page_content', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('page_id')->unsigned()->index();
            $table->integer('author_id')->unsigned()->index();

            $table->string('section')->nullable()->default(null);
            $table->text('content')->nullable()->default(null);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $prefix = $this->prefix;

        Schema::drop($prefix.'page_content');
        Schema::drop($prefix.'pages');
    }
}
