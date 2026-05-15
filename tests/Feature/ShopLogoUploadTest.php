<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

it('converts an uploaded image to webp using Intervention Image v4 API', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('logo.png', 800, 600);

    $manager = new ImageManager(new GdDriver);
    $image = $manager->decode($file);
    $image->scale(width: 600);
    $encoded = $image->encode(new WebpEncoder(quality: 80));

    $path = 'logos/test-logo.webp';
    Storage::disk('public')->put($path, (string) $encoded);

    Storage::disk('public')->assertExists($path);
    expect(strlen((string) $encoded))->toBeGreaterThan(0);
});
