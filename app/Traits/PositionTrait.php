<?php

namespace App\Traits;


trait PositionTrait
{

    /**
     * Устанавливает позицию у указанной записи и обновляет позиции у остальных
     * учитывая поднялась запись или опустилась
     *
     * @param $new_position
     * @param $className
     * @return bool
     */
    public function updatePosition($new_position, $parent_field_name = null)
    {
        $className = get_class($this);

        if($new_position < 1) {
            $new_position = 1;
        }

        $parentField = $parent_field_name ?? 'parent_id';

        switch ($new_position <=> $this->pos){
            case -1: // новая позиция меньше текушей (строчка поднимается)
                $className::when(isset($this->$parentField), function($q) use ($parentField){
                    $q->where($parentField, $this->$parentField);
                })->whereBetween('pos', [$new_position, $this->pos-1])->increment('pos', 1);
                break;
            case 1: // новая позиция больше текушей (строчка опускается)
                $max_pos = $className::when(isset($this->$parentField), function($q) use ($parentField){
                    $q->where($parentField, $this->$parentField);
                })->max('pos');
                if($new_position > $max_pos) {
                    $new_position = $max_pos;
                }
                $className::when(isset($this->$parentField), function($q) use ($parentField){
                    $q->where($parentField, $this->$parentField);
                })->whereBetween('pos', [$this->pos+1, $new_position])->decrement('pos', 1);
                break;
            case 0:
                return false;
        }

        $this->update(['pos' => $new_position]);
        return true;
    }

    /**
     * Удаление записи и обновление позиций у оставшихся записей
     */
    public function deleteWithUpdatePosition($parent_field_name = null)
    {
        $parentField = $parent_field_name ?? 'parent_id';

        $this->when(isset($this->$parentField), function($q) use ($parentField){
            $q->where($parentField, $this->$parentField);
        })->where('pos','>',$this->pos)->decrement('pos', 1);
        $this->delete();
    }
}
