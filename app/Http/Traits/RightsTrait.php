<?php

namespace App\Http\Traits;

use App\Http\Models\Cats\CatRightsRecommendation;
use stdClass;

trait RightsTrait
{
    public static function orderRights($itemRight,$itemSubRight, $items)
    {
        $data = CatRightsRecommendation::with('subrights.subcategories')->where('isActive', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        $idsEdit = [];
        $idsRight = [];
        $idsSubRight = [];

        if ($items!==null){
            foreach ($items as $item){
                array_push($idsEdit, $item->id);
            }
        }

        if ($itemRight!==null){
            foreach ($itemRight as $itemR){
                $var = true;
                foreach ($idsRight as $id){
                    if ($itemR->id===$id){
                        $var=false;
                    }
                }
                if ($var){
                    array_push($idsRight, $itemR->id);
                }
            }
        }

        if ($itemSubRight!==null){
            foreach ($itemSubRight as $itemS){
                $var = true;
                foreach ($idsSubRight as $id){
                    if ($itemS->id===$id){
                        $var=false;
                    }
                }
                if ($var){
                    array_push($idsSubRight, $itemS->id);
                }
            }
        }

        $showIds = [];
        $list=[];
        $grandfather=[];

        $long=0;
        $longFather = count($data);

        foreach ($data as $length){
            for ($i=0;$i<count($length->subrights);$i++){
                $long++;
            }

        }
        $long = $long+$longFather;
        foreach ($data as $r) {
            $father = [];
            foreach ($r->subrights as $sub) {
                $children = [];
                foreach ($sub->subcategories as $category){
                    $long++;
                    $children[] = [
                        'id' => $long,
                        'label' => $category->name,
                        'right_id' => $r->id,
                        'subrights_id' => $sub->id,
                        'subcategory_id' => $category->id,
                        'add'      => 1,
                    ];
                    foreach ($idsEdit as $value){
                        if ($value===$category->id){
                            array_push($showIds,$long);
                            $list[] = [
                                'id' => $long,
                                'label' => $category->name,
                                'right_id' => $r->id,
                                'subrights_id' => $sub->id,
                                'subcategory_id' => $category->id,
                                'add'      => 1,
                            ];
                        }
                    }
                }
                $longFather++;
                $father[] = [
                    'id' => $longFather,
                    'label' => $sub->name,
                    'right_id' => $r->id,
                    'subrights_id'=> $sub->id,
                    'subcategory_id' => null,
                    'children' => $children,
                    'add'      => $children ? 0 : 1,
                ];
            }
            foreach ($father as $f){
                if ($f['add']===1){
                    foreach($idsSubRight as $id){
                        if($id===$f['subrights_id']){
                            array_push($showIds,$f['id']);
                            array_push($list,$f);
                        }
                    }
                }
            }
            $grandfather[] = [
                'id' => $r->id,
                'label' => $r->name,
                'children' => $father,
                'right_id' => $r->id,
                'subrights_id' => null,
                'subcategory_id' => null,
                'add'      => $father ? 0 : 1,
            ];
            foreach ($grandfather as $g){
                if ($g['add']===1){
                    foreach($idsRight as $id){
                        if($id===$g['right_id']){
                            array_push($showIds,$g['id']);
                            array_push($list,$g);
                        }
                    }
                }
            }
        }
        $rights[]=[
            'id' => 0,
            'label' => 'Derechos Humanos',
            'children' => $grandfather
        ];
        if ($items!==null||$itemRight!==null||$itemSubRight!==null){
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
