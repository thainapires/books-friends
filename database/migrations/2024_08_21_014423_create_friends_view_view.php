<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Staudenmeir\LaravelMergedRelations\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $exists = DB::table('view_exists')->first()->friends_view_created ?? false;
        
        if (!$exists) {
            Schema::createMergeView('friends_view', [(new User())->acceptedFriendsOf(), (new User())->acceptedFriendsOfMine()]);
            
            // Set the flag to true indicating the view has been created
            DB::table('view_exists')->update(['friends_view_created' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friends_view');
        
        // Reset the flag
        DB::table('view_exists')->update(['friends_view_created' => false]);
    }
};
