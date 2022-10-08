<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string("uuid");
            $table->string("county");
            $table->string("country");
            $table->string("town");
            $table->string("postcode")->nullable();
            $table->longText("description");
            $table->string("address");
            $table->string("image");
            $table->string("thumbnail");
            $table->decimal('latitude', $precision = 8, $scale = 6)->nullable();
            $table->decimal('longitude', $precision = 9, $scale = 6)->nullable();
            $table->integer("bedrooms")->default(0);
            $table->integer("bathrooms")->default(0);
            $table->integer("price")->default(0);
            $table->integer("property_type");
            $table->string("type");
            $table->string("source");
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('properties');
    }
}
