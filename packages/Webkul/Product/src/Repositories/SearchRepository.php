<?php

namespace Webkul\Product\Repositories;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Traits\Sanitizer;

class SearchRepository extends ProductRepository
{
    use Sanitizer;

    /**
     * Upload provided image
     *
     * @param  array  $data
     * @return string
     */
    public function uploadSearchImage($data)
    {
        $file = request()->file('image');

        // Allowed MIME types for images
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
        ];

        // Allowed file extensions
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        // Validate MIME type
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            throw new \Exception('Invalid file type. Only PNG, JPG, and JPEG images are allowed.');
        }

        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception('Invalid file extension. Only .jpg, .jpeg, and .png extensions are allowed.');
        }

        $path = $file->store('product-search');

        $this->sanitizeSVG($path, $file->getMimeType());

        return Storage::url($path);
    }
}
