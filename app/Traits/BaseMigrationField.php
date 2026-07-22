<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

trait BaseMigrationField
{
    public function AddBaseFields(Blueprint $table, $useUUID = false, $useIsDelete = true)
    {
        $table->id();
        if ($useUUID) {
            $table->uuid()->default(DB::raw('gen_random_uuid()'));
            $table->index('uuid');
        }
        $table->timestampTz("created_at")->useCurrent();
        $table->timestampTz("updated_at")->useCurrent();
        $table->unsignedBigInteger('create_uid')->nullable();
        $table->unsignedBigInteger('update_uid')->nullable();
        // $table->unsignedBigInteger('create_uid')->nullable();
        // $table->unsignedBigInteger('create_uid')->nullable();

        if ($useIsDelete) {
            $table->boolean('is_deleted')->default(false);
            $table->unsignedBigInteger('deleted_uid')->nullable();
            $table->foreign('deleted_uid')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_reason')->nullable();
        }
    }
}

