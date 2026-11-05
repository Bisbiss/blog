<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\FileUpload;

class ImageUpload
{
    /**
     * FileUpload gambar standar: disimpan di disk public dan diperkecil di browser
     * (maks 1600px) sebelum diunggah supaya halaman tidak berat.
     */
    public static function make(string $name, string $directory): FileUpload
    {
        return FileUpload::make($name)
            ->image()
            ->disk('public')
            ->directory($directory)
            ->imageResizeMode('contain')
            ->imageResizeTargetWidth('1600')
            ->imageResizeTargetHeight('1600')
            ->imageResizeUpscale(false)
            ->maxSize(5120);
    }
}
