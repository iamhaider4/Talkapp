<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talk_proposal_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating')->unsigned()->comment('Rating from 1-5');
            $table->text('comments');
            $table->timestamps();
            
            // Ensure one review per talk proposal
            $table->unique('talk_proposal_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
