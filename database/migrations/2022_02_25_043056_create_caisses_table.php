<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaissesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caisse', function (Blueprint $table) {
            $table->increments('id_caisse');
            $table->tinyInteger('type_operation');
            $table->text('note')->nullable();;
            $table->timestamp('date_operation')->nullable();;
            $table->float('total_somme', 8, 2);
            $table->longText('detail_operation')->nullable();;
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
        Schema::dropIfExists('caisses');
    }
}
