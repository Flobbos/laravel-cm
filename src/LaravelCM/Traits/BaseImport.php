<?php

namespace Flobbos\LaravelCM\Traits;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            throw new \Exception(trans('crud.invalid_file_upload'));
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
     * Initialize results array/collection
     * @param type $results_format
     * @return void
     */
    public function initResults($results_format = null): self {
        if(!is_null($results_format)){
            $this->results = $results_format;
            return $this;
        }
        $this->results = collect([]);
        return $this;
    }
    
    /**
     * Load uploaded file into Excel
     * @param type $file
     * @return void
     */
    public function loadFile($file): void{
        //dd($this->excel);
        //$this->excel->load('storage/xls/'.$file, function($reader){
        Excel::load('storage/xls/'.$file, function($reader){
            //Go through sheets
            $reader->each(function($sheet){
                // Loop through all rows
                $sheet->each(function($row){
                    $this->pushRow($row);
                });
            });
        });
        return;
    }
    
    /**
     * Push a new row collection onto the results collection
     * @param type $row
     */
    protected function pushRow($row): void{
        if(!empty($row->first())){
            $this->results->push($row);
        }
        return;
    }
    
}