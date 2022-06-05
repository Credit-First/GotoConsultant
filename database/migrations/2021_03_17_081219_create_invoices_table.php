<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->date('from_date');
            $table->date('till_date');
            $table->enum('status', ['N', 'P'])->comment('  N=>Not paid, P=>Paid');

            $table->decimal('gtc_fee', 7, 2)->unsigned();
            $table->decimal('vat', 7, 2)->unsigned();
            $table->decimal('total', 7, 2)->unsigned();

            $table->json('ref_transactions');
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['creator_id', 'status', 'from_date', 'till_date'], 'invoices_creator_id_status_from_date_till_date_index');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
