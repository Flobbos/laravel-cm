<?php

namespace Flobbos\LaravelCM\Traits;

use Illuminate\Http\Request;
use Flobbos\LaravelCM\Imports\SubscriberImport;
use Exception;

trait BaseImport {
    
    protected $results;
    
    /**
     * Handle uploads
     * @param \App\Services\Request $request
     * @param type $fieldname
     * @param type $folder
     * @param type $storage_disk
     * @param type $randomize
     * @return string
     * @throws \Exception
     */
    public function handleUpload(Request $request, $fieldname = 'photo', $folder = 'images', $storage_disk = 'public', $randomize = true): string{
        if(is_null($request->file($fieldname)) || !$request->file($fieldname)->isValid()){
            throw new Exception(trans('crud.invalid_file_upload'));
        }
        //Get filename
        $basename = basename($request->file($fieldname)->getClientOriginalName(),'.'.$request->file($fieldname)->getClientOriginalExtension());
        if($randomize){
            $filename = uniqid().'_'.str_slug($basename).'.'.$request->file($fieldname)->getClientOriginalExtension();
        }
        else{
            $filename = str_slug($basename).'.'.$request->file($fieldname)->getClientOriginalExtension();
        }
        //Move file to location
        $request->file($fieldname)->storeAs($folder,$filename,$storage_disk);
        return $filename;
    }
    
    /**
     * Load uploaded file into Excel
     * @param type $file
     * @return void
     */
    public function importFile($file): void{
        $this->results = (new SubscriberImport)->toCollection(storage_path('app/public/xls/').$file);
        return;
    }
    
}
