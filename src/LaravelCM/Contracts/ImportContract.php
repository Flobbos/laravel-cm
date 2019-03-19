<?php
namespace Flobbos\LaravelCM\Contracts;
interface ImportContract {
    
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
    public function handleUpload(Request $request, $fieldname = 'photo', $folder = 'images', $storage_disk = 'public', $randomize = false): string;
    
    /**
     * Load uploaded file into Excel
     * @param type $file
     * @return void
     */
    public function importFile($file): self;
    
}