<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuditLogObserver
{
    public function created($model)
    {
        $this->logChange($model, 'created');
    }

    public function updated($model)
    {
        $this->logChange($model, 'updated');
    }

    public function deleted($model)
    {
        $this->logChange($model, 'deleted');
    }

    protected function logChange($model, $action)
    {
        if (Auth::check() && (Auth::user()->permission_id == '1' || Auth::user()->permission_id == '2' || Auth::user()->permission_id == '3')) {
            $userDetail = ""; // Initialize a variable to hold user-specific details
            $modelName = class_basename(get_class($model)); // Get a simple model name
    
            // Check if the model has a user-related attribute, e.g., 'user_id' or 'username'
            if (isset($model->user_id)) {
                $affectedUser = User::find($model->user_id);
                $userDetail = " for user {$affectedUser->name} with the user ID: {$affectedUser->id}";
            }
    
            // Customize description based on the action
            $description = "{$action} a {$modelName}{$userDetail}";
    
            AuditLog::create([
                'action' => $action,
                'auditable_id' => $model->id,
                'auditable_type' => get_class($model) . ' ' . $model->id,
                'user_id' => auth()->id(),
                'description' => $description,
                'created_at' => now()->setTimezone('Asia/Manila'),
                'permission_type' => Auth::user()->permission_id == '1' ? 'General Manager' : (Auth::user()->permission_id == '2' ? 'Accountant' : (Auth::user()->permission_id == '3' ? 'Book keeper' : 'Guest'))
            ]);
        }
    }
}

