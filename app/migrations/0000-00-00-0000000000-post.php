<?php

use CandleLight\App;
use CandleLight\Migration;
use Illuminate\Database\Schema\Blueprint;

/* @var App $app */
$app->addMigration(__FILE__, new class($app) extends Migration{

    /**
     * Method called, when the migration is executed
     */
    public function up(): void{
        $schema = $this->getSchema('default');
        $schema->create('post', function (Blueprint $table){
            $table->increments('id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('content');
            $table->text('meta');
            $table->timestamps();
        });
    }

    /**
     * Method called, when the migration is rolled back
     */
    public function down(): void{
        $this->getSchema('default')->drop('post');
    }
});