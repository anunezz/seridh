<?php

namespace App\Http\Traits;

use App\Http\Models\Cats\CatRightsRecommendation;
use stdClass;

trait RightsTrait
{
    public static function orderRights($items)
    {
        $data = CatRightsRecommendation::with('subrights')->where('isActive', 1)
            ->orderBy('name')
            ->get(['id', 'name']);
        $total = count($data);
        $father = [];
        $idsEdit = [];
        if ($items!==null){
            foreach ($items as $item){
                array_push($idsEdit, $item->id);
            }
        }

        $showIds = [];
        $list=[];
        foreach ($data as $r) {
            $children = [];
            foreach ($r->subrights as $sub) {
                if ($items!==null){
                    $total++;
                    $children[] = [
                        'id' => $total,
                        'label' => $sub->name,
                        'right_id' => $r->id,
                        'subright_id' => $sub->id,
                    ];
                    foreach ($idsEdit as $value){
                        if ($value===$sub->id){
                            array_push($showIds,$total);
                            $list[] = [
                                'id' => $total,
                                'label' => $sub->name,
                                'right_id' => $r->id,
                                'subright_id' => $sub->id,
                            ];
                        }
                    }
                }else{
                    $children[] = [
                        'id' => $sub->id,
                        'label' => $sub->name,
                        'right_id' => $r->id
                    ];
                }

            }
            $father[] = [
                'id' => $r->id,
                'label' => $r->name,
                'children' => $children
            ];
        }
        $rights[]=[
            'id' => 0,
            'label' => 'Derechos Humanos',
            'children' => $father
        ];
        if ($items!==null){
            return $aux = [
                'rights'           => $rights,
                'showIds'          => $showIds,
                'listR'            => $list
            ];
        }else{
            return $rights;
        }
    }
}
