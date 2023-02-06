<?php
namespace App\Http\Services\Uploads;

use App\Repositories\Compressions\Images\ImageRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * @var ImageRepositoryInterface
     */
    private ImageRepositoryInterface $imageRepository;

    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param $file_64
     * @param array $options
     * @param string $path
     * @param string $namePrefix
     * @return string
     */
    public function uploadFile($file_64, array $options = [], string $path = '', string $namePrefix = '') : string
    {
        $extension = explode('/', mime_content_type($file_64))[1];
        $fileName = $namePrefix.uniqid().".".$extension;
        $folder = public_path('/storage/'.$path);
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true, true);
        }

        $fileBase64 = explode(',', $file_64)[1];
        Storage::disk('public')->put($path.$fileName, base64_decode($fileBase64));

        if (isset($options) && !empty($options)) {
            if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                $options['imagePath'] = storage_path('app/public/').$path.$fileName;
                if (isset($options['width']) && isset($options['height'])) {
                    $this->imageRepository->resize($options);
                    $this->imageRepository->optimize($options);
                } else {
                    $this->imageRepository->optimize($options);
                }
            } else {
                //pdf
                shell_exec("gs -q -dNOPAUSE -dBATCH -dSAFER -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dEmbedAllFonts=true -dSubsetFonts=true -dColorImageDownsampleType=/Bicubic -dColorImageResolution=144 -dGrayImageDownsampleType=/Bicubic -dGrayImageResolution=144 -dMonoImageDownsampleType=/Bicubic -dMonoImageResolution=144 -sOutputFile=".storage_path('app/public/').$path."compressed".$fileName." ". storage_path('app/public/').$path.$fileName);
                $this->deleteFile(storage_path('app/public/').$path.$fileName);
                $fileName = "compressed".$fileName;
            }

        } else {
            $fileBase64 = explode(',', $file_64)[1];
            Storage::disk('public')->put($path.$fileName, base64_decode($fileBase64));
        }
        return $path.$fileName;
    }

    public function deleteFile(string $path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
