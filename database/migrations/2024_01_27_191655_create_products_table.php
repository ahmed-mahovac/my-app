<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE TABLE products (
            product_id INT PRIMARY KEY AUTO_INCREMENT,
            product_type_id INT,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10, 2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (product_type_id) REFERENCES product_types(product_type_id)
        );');

        // add full text index on 'name' column

        Schema::table('products', function (Blueprint $table) {
            $table->string('state')->default('DRAFT');
            $table->string('activated_by')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->fullText('name');
        });

        /* raw way
        DB::statement('ALTER TABLE products ADD FULLTEXT fulltext_index (name);');
         */

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_name_fulltext');
        });
        Schema::dropIfExists('products');
    }
}
