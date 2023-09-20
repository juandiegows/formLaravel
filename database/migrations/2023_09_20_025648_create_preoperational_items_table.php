<?php

use App\Models\PreoperationalCategory;
use App\Models\PreoperationalItemType;
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
        Schema::create('preoperational_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(PreoperationalCategory::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(PreoperationalItemType::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preoperational_items');
    }
};
