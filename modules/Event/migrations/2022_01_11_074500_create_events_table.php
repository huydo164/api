<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Event\Models\Event;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('start_date');
            $table->integer('category_id');
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->text('risk')->nullable();
            $table->tinyInteger('status')->default(Event::EVENT_STATUS_PROCESSING);
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
        Schema::dropIfExists('events');
    }
}
