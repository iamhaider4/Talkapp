<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('talk_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talk_proposal_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('changes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('talk_revisions');
    }
};
