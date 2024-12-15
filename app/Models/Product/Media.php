<?php

namespace App\Models\Product;
use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['path'];

    /**
     * Save image to storage
     *
     * @param string $image base64 image
     * @param array $options ['path' => '', 'resize' => false]
     * @return true
     */
    
    public function saveImage(string $encodedImage, $options = [])
    {
        $supportedImages = ['jpg', 'jpeg', 'png', 'svg'];

        $path = $this->convertPath($options['path']);
        $image = base64_decode($encodedImage);
        $extension = Helper::getFileExtension($image) ?? abort(400, 'Image format not recognized.');

        if (!in_array($extension, $supportedImages)) {
            abort(400, 'Unsupported image format. It should either: ' . implode(', ', $supportedImages));
        }

        Storage::put("$path.$extension", $image) ?? abort('Saving failed');

        // Generate small, medium, large
        if ($options['resize']) {
            $resizedImage = Helper::generateResizedImage($image);
            foreach ($resizedImage as $size => $image) {
                if ($size == 'normal') continue;
                $resizedPath = "${path}-${size}.{$extension}";
                Storage::put($resizedPath, $image) ?? abort('Saving failed');
            }
        }

        $this->path = str_replace('public/', 'storage/', "$path.$extension");

        $this->save();

        return $this;
    }

    private function convertPath(string $path)
    {
        preg_match_all("/\{[^\}]*\}/", $path, $matches);

        $textToConvert = $matches[0];

        foreach ($textToConvert as $text) {
            $search = explode('.', trim($text, '{}'));
            $obj = $this->imageable;

            foreach($search as $var) {
                $obj = $obj->$var;
            }

            $path = str_replace($text, $obj, $path);
        }

        return $path;
    }

    /**
     * Get accessable url for the image path.
     */
    public function getUrlAttribute()
    {
        return asset($this->attributes['path']);
    }

    public function imageable()
    {
        return $this->morphTo();
    }

    
}
