<?php

namespace App\Http\Controllers\Traits;

trait UpdateFieldsTrait
{

    /**
     * Сравнивает новое значение новых полей со значениями полей в модели
     * и возвращает массив с изменениями или null
     *
     * @param array $data - новые данные
     * @param object $model - модель, для которой новые данные предназначены
     * @return array|null
     */
    public function checkFieldsUpdateChanges(array $data, $model)
    {
        $changes = null;
        $model_fields = $model->getFillable();
        foreach ($data as $field => $value ){
            if(in_array($field, $model_fields) && $model->$field != $value){
                $result = $value !== null ? 'изменено на "' . $value .'"' : 'удалено';
                $changes[] = 'Значение поля "' . __('validation.attributes.'.$field) . '" ' . $result;
            }
        }
        return $changes;
    }

}