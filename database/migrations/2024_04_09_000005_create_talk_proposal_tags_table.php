<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('talk_proposal_tag', function (Blueprint $table) {
            $table->foreignId('talk_proposal_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->primary(['talk_proposal_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('talk_proposal_tag');
    }
};
