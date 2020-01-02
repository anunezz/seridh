<?php

namespace App\Http\Traits;


use App\Http\Models\Cats\CatOds;


trait GoalsOdsTrait
{
    public static function orderOds($items)
    {
        $data = CatOds::with('goalsOds')
                ->where('isActive', 1)
                ->get(['id', 'name']);

        $total = count($data);
        $ideEdit = [];
         $goalsOds = [];
        if ($items!==null){
            foreach ($items as $item){
                array_push($ideEdit, $item->id);
            }
        }



        $showIde = [];
        $lists=[];
        foreach ($data as  $ods) {
             $goals = [];

            foreach ( $ods->goalsOds as  $goal) {
                        $total++;
                         $goals[] = [
                            'id' => $total,
                            'label' =>  $goal->name,
                            'ods_id' =>  $ods -> id,
                            'cat_goal_id' =>  $goal->id,
                        ];
                        foreach ($ideEdit as $value){
                            if ($value=== $goal->id){
                                array_push($showIde,$total);
                                $lists[] = [
                                    'id' => $total,
                                    'label' =>  $goal->name,
                                    'ods_id' =>  $ods->id,
                                    'cat_goal_id' =>  $goal->id,
                                ];
                            }
                        }
            }
             $goalsOds[] = [
                'id' =>  $ods->id,
                'label' =>  $ods->name,
                'children' =>  $goals
            ];
        }
        $tree[]=[
            'id' => 0,
            'label' => 'Objetivos de Desarrollo Sostenible',
            'children' =>  $goalsOds
        ];

        return $tree = [
            'tree'            => $tree,
            'showOdsIds'          => $showIde,
            'listOds'        => $lists
        ];

    }
}
