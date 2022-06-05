<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddCompletedStripeOnboardingField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->decimal('total_amount', 7, 2)->unsigned()->after('vat_amount')->default(0);
            $table->boolean('completed_stripe_onboarding')->after('stripe_cus_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('completed_stripe_onboarding');        
        });
    }
}
