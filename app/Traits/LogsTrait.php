<?php

namespace App\Traits;

use App\Log;

trait LogsTrait
{

    public function setLog($message, $user_id = null)
    {
        $this->logs()->create([
            'user_id' => $user_id ?? \Auth::id(),
            'text' => $message,
            'ip' => \Request::ip(),
        ]);
    }

    public function setLogs(array $messages, $user_id = null)
    {
        foreach ($messages as $message){
            $this->setLog($message, $user_id);
        }
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'logable');
    }

    public function getLogsName()
    {
        return 'выбранная запись';
    }

}
