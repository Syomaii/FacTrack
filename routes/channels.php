<?php

use App\Models\Equipment;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('overdue-equipment', function ($user, $equipmentId) {

    $equipment = Equipment::with('facility')->find($equipmentId);

    if (!$equipment || !$equipment->facility) {
        return false; 
    }

    return $user->office_id === $equipment->facility->office_id && $user->type !== 'student';
});
