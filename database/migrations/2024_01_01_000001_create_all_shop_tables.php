<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add extra columns to users table if not exist
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'phone')) {
                    $table->string('phone', 15)->nullable()->unique()->after('email');
                }
                if (!Schema::hasColumn('users', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('role');
                }
                if (!Schema::hasColumn('users', 'cart_data')) {
                    $table->text('cart_data')->nullable()->after('updated_at');
                }
            });
        }

        // Categories
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->boolean('is_active')->default(true);
            });
        }

        // Products
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('category_id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->decimal('base_price', 10, 2);
                $table->string('image_url', 500)->nullable();
                $table->boolean('allow_topping')->default(true);
                $table->boolean('is_active')->default(true);
                $table->boolean('is_bestseller')->default(false);

                $table->foreign('category_id')->references('id')->on('categories');
            });
        }

        // Option Groups
        if (!Schema::hasTable('option_groups')) {
            Schema::create('option_groups', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('display_type', 20)->default('radio'); // radio, checkbox
            });
        }

        // Option Values
        if (!Schema::hasTable('option_values')) {
            Schema::create('option_values', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('group_id');
                $table->string('name', 50);
                $table->decimal('price_adjustment', 10, 2)->default(0);
                $table->boolean('is_default')->default(false);

                $table->foreign('group_id')->references('id')->on('option_groups')->onDelete('cascade');
            });
        }

        // Product Option Groups (pivot)
        if (!Schema::hasTable('product_option_groups')) {
            Schema::create('product_option_groups', function (Blueprint $table) {
                $table->unsignedBigInteger('product_id');
                $table->unsignedBigInteger('group_id');

                $table->primary(['product_id', 'group_id']);
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('group_id')->references('id')->on('option_groups')->onDelete('cascade');
            });
        }

        // Toppings
        if (!Schema::hasTable('toppings')) {
            Schema::create('toppings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->decimal('price', 10, 2);
                $table->boolean('is_available')->default(true);
            });
        }

        // Carts
        if (!Schema::hasTable('carts')) {
            Schema::create('carts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->unique();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // Cart Items
        if (!Schema::hasTable('cart_items')) {
            Schema::create('cart_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cart_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity')->default(1);
                $table->text('options')->nullable();
                $table->text('toppings')->nullable();
                $table->timestamps();

                $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }

        // Cart Item Options (pivot)
        if (!Schema::hasTable('cart_item_options')) {
            Schema::create('cart_item_options', function (Blueprint $table) {
                $table->unsignedBigInteger('cart_item_id');
                $table->unsignedBigInteger('option_value_id');

                $table->primary(['cart_item_id', 'option_value_id']);
                $table->foreign('cart_item_id')->references('id')->on('cart_items')->onDelete('cascade');
                $table->foreign('option_value_id')->references('id')->on('option_values')->onDelete('cascade');
            });
        }

        // Cart Item Toppings (pivot)
        if (!Schema::hasTable('cart_item_toppings')) {
            Schema::create('cart_item_toppings', function (Blueprint $table) {
                $table->unsignedBigInteger('cart_item_id');
                $table->unsignedBigInteger('topping_id');

                $table->primary(['cart_item_id', 'topping_id']);
                $table->foreign('cart_item_id')->references('id')->on('cart_items')->onDelete('cascade');
                $table->foreign('topping_id')->references('id')->on('toppings')->onDelete('cascade');
            });
        }

        // Orders
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone', 15);
                $table->text('customer_address');
                $table->decimal('total_amount', 10, 2);
                $table->string('status', 20)->default('pending'); // pending, processing, completed, cancelled
                $table->string('payment_method', 50)->default('cod');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Order Items
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('product_id')->nullable();
                $table->string('product_name');
                $table->string('product_image', 500)->nullable();
                $table->integer('quantity')->default(1);
                $table->decimal('price', 10, 2);
                $table->text('options')->nullable();
                $table->text('toppings')->nullable();
                $table->timestamps();

                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            });
        }

        // User Addresses
        if (!Schema::hasTable('user_addresses')) {
            Schema::create('user_addresses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('recipient_name');
                $table->string('recipient_phone', 15);
                $table->text('address_line');
                $table->boolean('is_default')->default(false);
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_item_toppings');
        Schema::dropIfExists('cart_item_options');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('toppings');
        Schema::dropIfExists('product_option_groups');
        Schema::dropIfExists('option_values');
        Schema::dropIfExists('option_groups');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
