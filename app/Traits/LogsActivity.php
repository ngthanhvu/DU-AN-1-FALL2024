<?php

namespace App\Traits;

use App\Models\Log;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        // Sự kiện "created"
        static::created(function ($model) {
            self::writeLog('create', $model, $model->toArray());
        });

        // Sự kiện "updated"
        static::updated(function ($model) {
            self::writeLog('update', $model, [
                'before' => $model->getOriginal(),
                'after' => $model->getChanges(),
            ]);
        });

        // Sự kiện "deleted"
        static::deleted(function ($model) {
            self::writeLog('delete', $model, $model->toArray());
        });
    }

    private static function writeLog($action, $model, $changes = null)
    {
        Log::create([
            'action' => $action,
            'model' => get_class($model),
            // 'user_id' => auth()->id(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'changes' => $changes ? json_encode($changes) : null,
        ]);
    }
}
