<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait formmaterBase64Trait
{

    public function pushBase64Image($imageBase64){

        if( empty($imageBase64) ) return null;
        
        $base64 = $imageBase64;
        $binaryData = base64_decode( $base64 );

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $binaryData);

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        if ( !isset($extensions[$mimeType]) ) {
            return response()->json(['error' => 'Tipo de imagen no soportado'], 415);
        }

        $filename= time() . '.' . $extensions[$mimeType];

        $path = 'products/' . $filename;
        Storage::disk('public')->put($path, $binaryData);

        $url = Storage::url('products/' . $filename);

        return $url;

    }

}
