<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    public function upload(UploadedFile $file, string $folder): string
    {
        if ($this->cloudinaryConfigured()) {
            $cloudinary = $this->cloudinary();
            $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => 'localmarket/' . $folder,
                'resource_type' => 'image',
            ]);
            return $result['secure_url'];
        }

        return $file->store($folder, 'public');
    }

    public function delete(string $path): void
    {
        if (str_starts_with($path, 'http')) {
            if ($this->cloudinaryConfigured()) {
                $publicId = $this->extractPublicId($path);
                if ($publicId) {
                    $this->cloudinary()->uploadApi()->destroy($publicId);
                }
            }
            return;
        }

        Storage::disk('public')->delete($path);
    }

    public function url(?string $path): ?string
    {
        if (!$path) return null;
        if (str_starts_with($path, 'http')) return $path;
        return asset('storage/' . $path);
    }

    private function cloudinaryConfigured(): bool
    {
        return !empty(config('cloudinary.cloud_name'));
    }

    private function cloudinary(): Cloudinary
    {
        return new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key'    => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);
    }

    private function extractPublicId(string $url): ?string
    {
        // Cloudinary URL: https://res.cloudinary.com/{cloud}/image/upload/v{ver}/{folder}/{public_id}.{ext}
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)\.\w+$/', $url, $m)) {
            return $m[1];
        }
        return null;
    }
}
