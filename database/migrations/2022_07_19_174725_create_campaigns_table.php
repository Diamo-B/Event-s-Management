<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitationId')->constrained('invitations')->nullable()->onDelete('cascade');
            $table->foreignId('eventId')->constrained('events')->nullable()->onDelete('cascade');
            $table->enum("status",['Original','Relanch','Complement']);
            $table->integer("relaunchNumber",false,true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};
