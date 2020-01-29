<?php

namespace App\Traits;

trait FlagsTrait
{
    /*
     *
     *  Скоупы
     *
     */

    public function scopeForFlag($q, $flag, $value = 1)
    {
        $q->where($flag, $value);
    }

    public function scopeForFlagOn($q, $flag)
    {
        $q->where($flag, 1);
    }

    public function scopeForFlagOff($q, $flag)
    {
        $q->where($flag, 0);
    }

    /* Скоупы (х) */

    public function isFlag($flag)
    {
        $this->checkFlagField($flag);
        return $this->$flag ? true : false;
    }

    public function toggleFlag($flag)
    {
        $this->checkFlagField($flag);

        $this->$flag = ! $this->$flag;
        $this->save();

        $log_message = 'Флаг "' . $flag . '" установлен в значение: ' . ($this->flag ? 'ДА' : 'НЕТ');

        $this->setLog($log_message);
    }

    private function checkFlagField($flag)
    {
        abort_if( ! isset($this->$flag), 500, 'У класса нет параметра '.$flag );
    }

    public function setFlagOn($flag, $message=null)
    {
        $this->checkFlagField($flag);
        $this->$flag = 1;
        $this->save();
        $this->setLog('Флаг "' . $flag . '" установлен в значение: ДА' . ($message ? '. '.$message : ''));
    }

    public function setFlagOff($flag, $message=null)
    {
        $this->checkFlagField($flag);
        $this->$flag = 0;
        $this->save();
        $this->setLog('Флаг "' . $flag . '" установлен в значение: НЕТ' . ($message ? '. '.$message : ''));
    }
}
