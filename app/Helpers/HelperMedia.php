<?php
//                      this name 1
namespace App\Helpers;

use App\Exceptions\BadRequestExcept;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Mime\Encoder\Base64Encoder;

class HelperMedia
{
    public static function getImageUrl(
        string $bucket,
        string $dirName,
        ?string $fileName,
        ?string $subDir = null,
        ?string $defualt = null
    ): ?string {
        if (empty($fileName)) {
            return $defualt ? asset($defualt) : null;
        }

        $paths = [
            public_path("uploads/images/{$bucket}/{$dirName}/{$fileName}")
        ];

        if ($subDir) {
            $paths[] = public_path("uploads/images/{$bucket}/{$dirName}/{$subDir}/{$fileName}");
        }

        $public = str_replace('\\', '/', public_path()) . '/';

        foreach ($paths as $path) {
            $normalizedPath = str_replace('\\', '/', $path);

            if (file_exists($normalizedPath)) {
                $relative = str_replace($public, '', $normalizedPath);

                return asset($relative);
            }
        }

        return $defualt ? asset($defualt) : null;
    }

    public static function getFileUrl(string $bucket, string $type, string $dirName, ?string $fileName, ?string $subDir = null, ?string $defualt = null): ?string
    {
        if (empty($fileName)) {
            return $defualt ? asset($defualt) : null;
        }

        $typePlural = Str::plural($type);
        $paths = [
            public_path("uploads/{$typePlural}/{$bucket}/{$dirName}/{$fileName}")
        ];

        if ($subDir) {
            $paths[] = public_path("uploads/{$typePlural}/{$bucket}/{$dirName}/{$subDir}/{$fileName}");
        }

        foreach ($paths as $path) {
            if (file_exists($path)) {
                $relative = str_replace(public_path() . '/', '', $path);
                return asset($relative);
            }
        }

        return $defualt ? asset($defualt) : null;
    }

    public static function getStreamFileUrl(
        string $bucket,
        string $type,
        string $dirName,
        ?string $fileName,
        ?string $subDir = null,
        ?string $defualt = null
    ): ?string {
        if (empty($fileName)) {
            return $defualt ? asset($defualt) : null;
        }

        $typePlural = Str::plural($type);
        $paths = [
            public_path("uploads/{$typePlural}/{$bucket}/{$dirName}/{$fileName}")
        ];

        if ($subDir) {
            $paths[] = public_path("uploads/{$typePlural}/{$bucket}/{$dirName}/{$subDir}/{$fileName}");
        }

        $videoExtensions = ['mp4', 'mov', 'webm', 'ogg'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (in_array($extension, $videoExtensions)) {
                    return route('file.stream', [
                        'bucket' => $bucket,
                        'dir'    => $dirName,
                        'file'   => $fileName,
                        'type'   => 'video',
                    ]);
                }

                if (in_array($extension, $imageExtensions)) {
                    return route('file.stream', [
                        'bucket' => $bucket,
                        'dir'    => $dirName,
                        'file'   => $fileName,
                        'type'   => 'image'
                    ]);
                }

                $relative = str_replace(public_path() . '/', '', $path);
                return asset($relative);
            }
        }
        return $defualt ? asset($defualt) : null;
    }

    public static function ensureBase64Prefix(string $base64String, string $imageType = 'png'): string
    {
        $prefixPattern = '/^data:image\/(\w+);base64,/';

        if (preg_match($prefixPattern, $base64String, $matches)) {
            $currentType = strtolower($matches[1]);
            if ($currentType !== strtolower($imageType)) {
                return preg_replace($prefixPattern, "data:image/{$imageType};base64,", $base64String, 1);
            }
            return $base64String;
        }
        return "data:image/{$imageType};base64,{$base64String}";
    }

    /**
     * Convert base64 iamge to file and save it
     *
     * folder structure: public/uploads/images/{bucket}/{dirName}/{subDir}
     *
     * @param string $base64String
     * @param string $bucket
     * @param string $dirName
     * @param string|null $subDir
     * @param string|null $ext
     * @return object { filename: string|null, path, string|null }
     */
    public static function base64ToImageFile(
        string $base64String,
        string $bucket,
        string $dirName,
        ?string $subDir = null,
        ?string $ext = null
    ): object {
        $fail = (object)['filename' => null, 'path' => null];

        $base64String = self::ensureBase64Prefix($base64String);
        if (!self::isValidBase64Image($base64String)) {
            return $fail;
        }

        $baseFolder = public_path("uploads/images/{$bucket}/{$dirName}" . ($subDir ? "/{$subDir}" : ''));
        File::ensureDirectoryExists($baseFolder, 0755);

        if (!preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            return $fail;
        }

        $fileExtension = $ext ?: strtolower($matches[1]);
        $imageData = base64_decode(explode(';base64,', $base64String, 2)[1] ?? '', true);

        if ($imageData === false) {
            return $fail;
        }

        $fileName = sprintf('%s%s%s.%s', $bucket, date('YmdHis'), uniqid(), $fileExtension);
        $filePath = "{$baseFolder}/{$fileName}";

        if (file_put_contents($filePath, $imageData) === false) {
            return $fail;
        }

        return (object)[
            'filename' => $fileName,
            'path'     => $filePath,
        ];
    }

    /**
     * Save an image from either a base64 string ar on uploaded file
     *
     * @param UploadedFile|string $imageOrBase64 Uploaded file or base64 string
     * @param string $bucket Main folder, e.g., 'uploads'
     * @param string $dirName Sub-folder, defualt 'images'
     * @param string|null $subDir Optional sub-derectory, e.g., user ID
     * @return object Storage result object (filename, path, mime, etc.)
     */
    public static function saveImageFileOrBase64($imageOrBase64, $bucket, $dirName = 'images', $subDir = null)
    {
        if (is_string($imageOrBase64) && self::isValidBase64Image($imageOrBase64)) {
            return self::base64ToImageFile($imageOrBase64, $bucket, $dirName, $subDir);
        } elseif ($imageOrBase64 instanceof UploadedFile) {
            return self::saveUploadedFile($imageOrBase64, 'image', $bucket, $dirName, $subDir);
        } else {
            return (object)[
                'path'     => null,
                'filename' => null
            ];
        }
    }

    /**
     * Check if value is a valid image (UploadFile or Base64)
     *
     * @param UploadedFile|string|Base64Encoder $image The image input
     * @param bool $throw Whether to throw on exception when invalid
     * @return bool
     * @throws BadRequestExcept if invalid and $throw = true
     */
    public static function isImage(UploadedFile|string|Base64Encoder $image, bool $throw = false): bool
    {
        $isImage = ($image instanceof UploadedFile) || self::isValidBase64Image($image);

        if ($throw && !$isImage) {
            throw new BadRequestExcept(__('validation.image', ['attribute' => 'image']));
        }

        return $isImage;
    }

    /**
     * Save an uploaded video file
     *
     * @param UploadedFile $file The uploaded video file
     * @param string $bucket The main storage folder (e.g., 'uploads')
     * @param string $dirName The directory name under the bucket (e.g., 'brands')
     * @param string|bull $subDir Optional subdirectory (e.g., user ID)
     * @return object Storage result object (e.g., { path, url, name, mime })
     */
    public static function saveUploadedVideo(
        UploadedFile $file,
        string $bucket,
        string $dirName,
        ?string $subDir = null
    ): object {
        return self::saveUploadedFile(
            file: $file,
            type: 'video',
            bucket: $bucket,
            dirName: $dirName,
            subDir: $subDir
        );
    }

    /**
     * Save multiple uploaded files (image, video, or file) to public/uploads/{type}/{bucket}/{dirName}/{subDir?}.
     *
     * @param array|Collection $files  Array or Collection of UploadedFile objects
     * @param string $type image|video|file
     * @param string $bucket
     * @param string $dirName
     * @param string|null $subDir
     * @return array  Array of objects [{ filename, ext, path, mime }]
     */
    public static function saveUploadedFiles(array|Collection $files, string $type, string $bucket, string $dirName, ?string $subDir = null): array
    {
        $results = [];

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                $results[] = (object)['filename' => null, 'ext' => null, 'path' => null, 'mime' => null];
                continue;
            }

            try {
                $results[] = self::saveUploadedFile($file, $type, $bucket, $dirName, $subDir);
            } catch (\Throwable $e) {
                Log::error('saveUploadedFile failed', [
                    'file'  => $file->getClientOriginalName(),
                    'error' => $e->getMessage(),
                ]);
                $results[] = (object)['filename' => null, 'ext' => null, 'path' => null, 'mime' => null];
            }
        }
        return $results;
    }

    /**
     * Save an uploaded file (image, video, audio, or file) to public/uploads/{type}/{bucket}/{dirName}/{subDir?}.
     *
     * @param UploadedFile $file
     * @param string $type image|video|audio|file
     * @param string $bucket
     * @param string $dirName
     * @param string|null $subDir
     * @return object { filename: string|null, ext: string|null, path: string|null, mime: string|null }
     */
    public static function saveUploadedFile(UploadedFile $file, string $type, string $bucket, string $dirName, ?string $subDir = null): object
    {
        $fail = (object)[
            'filename' => null,
            'ext'      => null,
            'path'     => null,
            'mime'     => null
        ];

        $validMimeTypes = [
            'image' => [
                'image/jpeg',
                'image/png',
                'image/jpg',
                'image/gif',
                'image/heic',
                'image/heif',
                'image/webp',
                'image/avif',
                'application/octet-stream'
            ],
            'video' => [
                'video/mp4',
                'video/mpeg',
                'video/quicktime',
                'video/x-msvideo',
                'video/x-ms-wmv',
                'video/webm',
                'video/3gpp',
            ],
            'audio' => [
                'audio/mpeg',
                'audio/mp3',
                'audio/wav',
                'audio/x-wav',
                'audio/webm',
                'audio/ogg',
                'audio/aac',
                'audio/m4a',
                'audio/x-m4a',
                'audio/3gpp',
            ],
            'file' => [
                'application/pdf',
                'application/zip',
                'text/plain',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
        ];

        if (!in_array($file->getClientMimeType(), $validMimeTypes[$type] ?? [])) {
            return $fail;
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'dat');
        $filename = sprintf(
            '%s_%s_%s.%s',
            $bucket,
            now()->format('YmdHis'),
            Str::random(8),
            $extension
        );

        $typePlural = Str::plural($type);
        $baseFolder = public_path("uploads/{$typePlural}/{$bucket}/{$dirName}" . ($subDir ? "/$subDir" : ''));
        File::ensureDirectoryExists($baseFolder, 0755);

        $file->move($baseFolder, $filename);

        return (object)[
            'filename' => $filename,
            'ext'      => $extension,
            'path'     => "{$baseFolder}/{$filename}",
            'mime'     => $file->getClientMimeType()
        ];
    }

    /**
     * Delete an uploaded file safely
     *
     * @param string $type   The category: image, video, audio, file
     * @param string $bucket The main folder
     * @param string $dirName Directory name under bucket
     * @param string $filename The file name to delete
     * @param string|null $subDir Optional subdirectory
     * @return bool True if deleted, false if file not found or error
     */
    public static function deleteUploadedFile(
        string $type,
        string $bucket,
        string $dirName,
        ?string $filename = '',
        ?string $subDir = null
    ): bool {

        $typePlural = Str::plural($type);
        $filePath = public_path("uploads/{$typePlural}/{$bucket}/{$dirName}" . ($subDir ? "/{$subDir}" : '') . "/{$filename}");

        if (!File::exists($filePath)) {
            return false;
        }

        try {
            return File::delete($filePath);
        } catch (\Exception $e) {
            Log::error("Failed to delete file: {$filePath}. Error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Save an uploaded image with multiple width & quality steps.
     *
     * @param UploadedFile $file
     * @param string $bucket
     * @param string $dirName
     * @param array $steps [['w'=>..., 'h'=>..., 'q'=>...], ...]
     * @param string|null $subDir
     * @return object {filename, ext, path, mime}
     */
    public static function saveImageWithSteps(
        UploadedFile $file,
        string $bucket,
        string $dirName,
        array $steps,
        ?string $subDir = null
    ): object {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $filename = sprintf('%s_%s_%s.%s', $bucket, now()->format('YmdHis'), Str::random(8), $extension);

        $baseFolder = public_path("uploads/image/{$bucket}/{$dirName}" . ($subDir ? "/{$subDir}" : ''));
        File::ensureDirectoryExists($baseFolder, 0755);

        $file->move($baseFolder, $filename);
        $filePath = "{$baseFolder}/{$filename}";
        $mime = $file->getClientMimeType();

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $src = imagecreatefromjpeg($filePath);
                break;
            case 'png':
                $src = imagecreatefrompng($filePath);
                break;
            case 'gif':
                $src = imagecreatefromgif($filePath);
                break;
            default:
                // Unsupported, return original only
                return (object)[
                    'filename' => $filename,
                    'ext'      => $extension,
                    'path'     => $filePath,
                    'mime'     => $mime,
                ];
        }

        $origWidth = imagesx($src);
        $origHeight = imagesy($src);

        foreach ($steps as $step) {
            $newWidth = $step['w'] ?? $origWidth;
            $newHeight = $step['h'] ?? intval($origHeight * ($newWidth / $origWidth));
            $quality = $step['q'] ?? 80;

            $dst = imagecreatetruecolor($newWidth, $newHeight);

            if (in_array($extension, ['png', 'gif'])) {
                imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            }

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

            $stepFilename = "w{$newWidth}_q{$quality}_{$filename}";
            $stepPath = "{$baseFolder}/{$stepFilename}";

            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($dst, $stepPath, max(1, min($quality, 100))); // clamp 1-100
                    break;
                case 'png':
                    // Convert quality 0-100 to compression 0-9 (inverted)
                    $pngCompression = intval((100 - $quality) / 10);
                    imagepng($dst, $stepPath, $pngCompression);
                    break;
                case 'gif':
                    imagegif($dst, $stepPath);
                    break;
                default:
                    throw new BadRequestExcept(__('messages.'));
            }
            imagedestroy($dst);
        }
        imagedestroy($src);

        return (object)[
            'filename' => $filename,
            'ext'      => $extension,
            'path'     => $filePath,
            'mime'     => $mime
        ];
    }

    public static function isValidBase64Image(string $base64String): bool
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String)) {
            [, $imageData] = explode(',', $base64String, 2);
        } else {
            $imageData = $base64String;
        }

        $decoded = base64_decode($imageData, true);
        if ($decoded === false) {
            return false;
        }

        $img = @imagecreatefromstring($decoded);
        if ($img === false) {
            return false;
        }

        imagedestroy($img);
        return true;
    }
}
