<?php

namespace App\Http\Controllers;

use App\Http\Models\CarouselImages;
use Illuminate\Http\Request;
use App\Http\Models\ConsolePublicRecommendation;
use App\User;
use DB;

class ConsolePublic extends Controller
{

    public function saveMessages(Request $request)
    {
        $data = $request->all();

            if ($data['type']==1){
            foreach ($data['ids'] as $id){
                $reg = null;
                $reg = CarouselImages::find($id);
                $reg->isActive = true;
                $reg->type = 1;
                $reg->save();
            }
            foreach ($data['idsDelete'] as $id){
                $regDelet = null;
                $regDelet = CarouselImages::find($id);
                $regDelet->isActive = false;
                $regDelet->type = 1;
                $regDelet->save();
            }
            return response()->json([
                'success'   => true
            ]);
        }else if ($data['type']==2){
            $data['path_dgdhd'] = $data['idDgdhd'];
            $data['path_undersecretary'] = $data['idSecre'];

            $confPublic = ConsolePublicRecommendation::find(1);
            $confPublic->fill($data);
            $confPublic->save();
        }else {
                foreach ($data['allAllies'] as $reg){
                    $ally = CarouselImages::find($reg['id']);
                    $ally->link = $reg['link'];
                    $ally->text= $reg['text'];
                    $ally->isActive = true;
                    $ally->save();
                    $ally = null;
                }
                foreach ($data['deletes'] as $id){
                    $ally = CarouselImages::find($id);
                    $ally->isActive = false;
                    $ally->save();
                }
            }
    }

    public function getData(Request $request)
    {
        try {
            if ($request->wantsJson()){
                $configPublic = ConsolePublicRecommendation::find(1);
                $pathUnsecre = CarouselImages::find($configPublic->path_undersecretary);
                $pathDgdhd = CarouselImages::find($configPublic->path_dgdhd);

                $dataPublic = [
                    'seridh'               => $configPublic->seridh,
                    'activeSeridh'         => $configPublic->activeSeridh == 1 ? true : false,
                    'undersecretary'       => $configPublic->undersecretary,
                    'path_undersecretary'  => [],
                    'idSecre'              => $configPublic->path_undersecretary,
                    'activeUndersecretary' => $configPublic->activeUndersecretary == 1 ? true : false,
                    'dgdhd'                => $configPublic->dgdhd,
                    'path_dgdhd'           => [],
                    'idDgdhd'              => $configPublic->path_dgdhd,
                    'activeDgdhd'          => $configPublic->activeDgdhd == 1 ? true : false,
                ];

                return response()->json([
                    'dataPublic' => $dataPublic,
                    'path_undersecretary'  => '/img/public/messages/'.$pathUnsecre->fileNameHash,
                    'path_dgdhd'           => '/img/public/messages/'.$pathDgdhd ->fileNameHash,
                    'success'   => true
                ]);
            }else{
                return response()->view('errors.404',[],400);
            }


        }
        catch ( \Exception $e ){
            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function updateImg(Request $request){
        try {
            DB::beginTransaction();

            if(isset($request->allies)){
                $file = new CarouselImages();
                $path = public_path().'/img/public/allies/';
                $document = $request->document;
                $nameHash = encrypt($file->id) . '.' . $document->extension();

                $file->user_id = auth()->user()->id;
                $file->fileName = $document->getClientOriginalName();
                $file->fileNameHash = $nameHash;
                $file->type = 3;
                $file->save();
                $document->move($path, $nameHash);
                DB::commit();

                return response()->json([
                    'success'    => true,
                    'documentId' => $file->id,
                    'fileName'   => $document->getClientOriginalName(),
                    'fileNameHash'   => $nameHash,
                    'path'      => '/img/public/allies/'.$nameHash
                ]);
            }else if (isset($request->carousel)){
                $file = new CarouselImages();
                $path = public_path().'/img/public/carousel/';
                $document = $request->document;
                $nameHash = encrypt($file->id) . '.' . $document->extension();

                $file->user_id = auth()->user()->id;
                $file->fileName = $document->getClientOriginalName();
                $file->fileNameHash = $nameHash;
                $file->type = 1;
                $file->save();
                $document->move($path, $nameHash);
                DB::commit();

                return response()->json([
                    'success'    => true,
                    'documentId' => $file->id,
                    'fileName'   => $document->getClientOriginalName(),
                    'fileNameHash'   => $nameHash,
                    'path'      => '/img/public/carousel/'.$nameHash
                ]);

            }else{
                $file = new CarouselImages();
                $path = public_path().'/img/public/messages/';
                $document = $request->document;
                $nameHash = encrypt($file->id) . '.' . $document->extension();

                $file->user_id = auth()->user()->id;
                $file->fileName = $document->getClientOriginalName();
                $file->fileNameHash = $nameHash;
                $file->type = 2;
                $file->save();
                $document->move($path, $nameHash);

                DB::commit();

                if (isset($request->undersecretary)){
                    return response()->json([
                        'success'    => true,
                        'ImgId' => $file->id,
                        'path'      => '/img/public/messages/'.$nameHash,
                        'type'      => 1
                    ]);
                } else {
                    return response()->json([
                        'success'    => true,
                        'ImgId' => $file->id,
                        'path'      => '/img/public/messages/'.$nameHash,
                        'type'      => 2
                    ]);
                }
                /*$path = public_path().'/img/public/messages/';
                $document = $request->document;
                $name = $document->getClientOriginalName();
                $document->move($path, $name);
                $url = '/img/public/messages/'.$name;

                $confPublic = ConsolePublicRecommendation::find(1);

                if (isset($request->undersecretary)){
                    $confPublic->path_undersecretary = $url;
                    $confPublic->save();
                }else{
                    $confPublic->path_dgdhd = $url;
                    $confPublic->save();
                }*/
            }

        }
        catch ( \Exception $e ) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function deleteImg(Request $request)
    {
        try {
            $data = $request->all();
            $path = public_path().$data['url'];
            $configPublic = ConsolePublicRecommendation::wherePathUndersecretary($data['url'])->orWhere('path_dgdhd',$data['url'])->first();
            if (file_exists($path)) {
                unlink($path);
            }

            if ($data['url']==$configPublic->path_undersecretary){
                $configPublic->path_undersecretary = null;
                $configPublic->save();
            }else{
                $configPublic->path_dgdhd = null;
                $configPublic->save();
            }
        }
        catch ( \Exception $e ){
            return response()->json([
                'success' => false,
                'message' => dd($e)
            ]);
        }
    }

    public function carouselImages(Request $request)
    {
        if ($request->wantsJson()){
            return CarouselImages::whereIsactive(1)->whereType(1)->get();
        }else{
            return response()->view('errors.404',[],404);
        }
    }

    public function alliesImages(Request $request)
    {
        if ($request->wantsJson()){
            return CarouselImages::select('id','fileNameHash','text','link')->whereIsactive(1)->whereType(3)->get();
        }else{
            return response()->view('errors.404',[],404);
        }

    }

}
