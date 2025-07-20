<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class base64image implements ValidationRule
{

    protected $allowedExtensions = [
        'image/jpg' => 'jpg',
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        if( !is_string($value) ){
            $fail('El campo no contiene una imagen valida en formato base64');
            return;
        }

        $base64 = $value;
        $binaryData = base64_decode( $base64 );

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $binaryData);
        finfo_close($finfo);

        if ( !in_array($mimeType, $this->allowedExtensions) ) {

            $fail('El tipo de imagen no esta permitido, solo se permiten '.implode(', ', $this->allowedExtensions));
            return;

        }

        $maxBytes = 1500 * 1024;

        if( strlen($binaryData) > $maxBytes ){
            $fail('El tamaño de la imagen es demasiado grande, el maximo permitido es '.$maxBytes.' bytes');
            return;
        }

    }
}
