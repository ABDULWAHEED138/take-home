<?php

use App\Models\Category;
use App\Models\Source;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Source::class)->constrained();
            $table->foreignIdFor(Category::class)->constrained();
            $table->string('author')->nullable();
            $table->string('title')->nullable();
            $table->string('description', 512)->nullable();
            $table->string('url')->nullable();
            $table->string('image_url')->nullable();
            $table->dateTime('publish_at')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
