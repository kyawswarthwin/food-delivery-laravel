<?php
/**
 * File name: 2020_05_14_121917_fixing_columns_v200.php
 * Last modified: 2020.05.14 at 13:19:17
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixingColumnsV200 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!\Doctrine\DBAL\Types\Type::hasType('double')) {
            \Doctrine\DBAL\Types\Type::addType('double', \Doctrine\DBAL\Types\FloatType::class);
            \Doctrine\DBAL\Types\Type::addType('tinyinteger', \Doctrine\DBAL\Types\SmallIntType::class);
            \Doctrine\DBAL\Types\Type::addType('timestamp', \Doctrine\DBAL\Types\DateTimeType::class);
        }
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('device_token')->nullable()->change();
                $table->string('stripe_id')->nullable()->change();
                $table->string('card_brand')->nullable()->change();
                $table->string('card_last_four')->nullable()->change();
                $table->timestamp('trial_ends_at')->nullable()->change();
                $table->string('braintree_id')->nullable()->change();
                $table->string('paypal_email')->nullable()->change();
            });
        }

        if (Schema::hasTable('restaurants')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->double('admin_commission', 8, 2)->nullable()->default(0)->change();
                $table->double('delivery_fee', 8, 2)->nullable()->default(0)->change();
                $table->double('delivery_range', 8, 2)->nullable()->default(0);
                $table->double('default_tax', 8, 2)->nullable()->default(0);
                $table->boolean('closed')->nullable()->default(0); // //added
                $table->boolean('available_for_delivery')->nullable()->default(1);
            });
        }

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->text('description')->nullable();
            });
        }

        if (Schema::hasTable('foods')) {
            Schema::table('foods', function (Blueprint $table) {
                $table->double('discount_price', 8, 2)->nullable()->default(0)->change();
                $table->text('description')->nullable()->change();
                $table->text('ingredients')->nullable()->change();
                $table->double('package_items_count', 9, 2)->nullable()->default(0); // added
                $table->double('weight', 9, 2)->default(0)->change();
                $table->string('unit', 127)->nullable(); // added
                $table->boolean('featured')->nullable()->default(0)->change();
                $table->boolean('deliverable')->nullable()->default(1); // added
            });
        }

        if (Schema::hasTable('galleries')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->text('description')->nullable()->change();
            });
        }

        if (Schema::hasTable('food_reviews')) {
            Schema::table('food_reviews', function (Blueprint $table) {
                $table->text('review')->nullable()->change();
                $table->unsignedTinyInteger('rate')->default(0)->change();
            });
        }

        if (Schema::hasTable('nutrition')) {
            Schema::table('nutrition', function (Blueprint $table) {
                $table->integer('quantity')->unsigned()->nullable()->default(0)->change();
            });
        }


        if (Schema::hasTable('extras')) {
            Schema::table('extras', function (Blueprint $table) {
                $table->text('description')->nullable()->change();
                $table->double('price', 8, 2)->nullable()->default(0)->change();
                $table->integer('extra_group_id')->nullable()->unsigned();
                $table->foreign('extra_group_id')->references('id')->on('extra_groups')->onDelete('set null')->onUpdate('set null');
            });
        }

        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('description', 255)->nullable()->change();
                $table->string('status')->nullable()->change();
                $table->string('method')->nullable()->change();
            });
        }

        if (Schema::hasTable('faqs')) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->text('question')->nullable()->change();
                $table->text('answer')->nullable()->change();
            });
        }

        if (Schema::hasTable('restaurant_reviews')) {
            Schema::table('restaurant_reviews', function (Blueprint $table) {
                $table->text('review')->nullable()->change();
                $table->unsignedTinyInteger('rate')->default(0)->change();
            });
        }

        if (Schema::hasTable('delivery_addresses')) {
            Schema::table('delivery_addresses', function (Blueprint $table) {
                $table->string('description', 255)->nullable()->change();
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->double('tax', 5, 2)->nullable()->default(0)->change();
                $table->double('delivery_fee', 5, 2)->nullable()->default(0)->change();
                $table->text('hint')->nullable()->change();
                $table->boolean('active')->default(1); // added
                $table->integer('driver_id')->nullable()->unsigned()->change();
                $table->integer('delivery_address_id')->nullable()->unsigned()->change();
                $table->integer('payment_id')->nullable()->unsigned()->change();
            });
        }

        if (Schema::hasTable('currencies')) {
            Schema::table('currencies', function (Blueprint $table) {
                $table->unsignedTinyInteger('decimal_digits')->nullable()->change();
                $table->unsignedTinyInteger('rounding')->nullable()->change();
            });
        }

        if (Schema::hasTable('drivers_payouts')) {
            Schema::table('drivers_payouts', function (Blueprint $table) {
                $table->string('method', 127)->nullable()->change();
                $table->dateTime('paid_date')->nullable()->change();
                $table->text('note')->nullable()->change();
            });
        }

        if (Schema::hasTable('restaurants_payouts')) {
            Schema::table('restaurants_payouts', function (Blueprint $table) {
                $table->string('method', 127)->nullable()->change();
                $table->dateTime('paid_date')->nullable()->change();
                $table->text('note')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
