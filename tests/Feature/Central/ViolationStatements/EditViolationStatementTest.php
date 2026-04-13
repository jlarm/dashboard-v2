<?php

declare(strict_types=1);

use App\Http\Livewire\Central\ViolationStatements\Edit;
use App\Models\ViolationStatement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

/**
 * Build a fake S3-style URL that deleteStoredImage() can correctly parse back
 * to the stored path via parse_url + ltrim.
 */
function fakeS3Url(string $path): string
{
    return 'https://test-bucket.nyc3.digitaloceanspaces.com/'.$path;
}

beforeEach(function (): void {
    Storage::fake('digitalocean');
});

it('deletes the old stored image when a new image is uploaded', function (): void {
    $storagePath = 'violation-statements/old-image.jpg';
    Storage::disk('digitalocean')->put($storagePath, 'old content');

    $statement = ViolationStatement::factory()->create([
        'reference_image_url' => fakeS3Url($storagePath),
    ]);

    Livewire::test(Edit::class, ['violationStatement' => $statement])
        ->set('newImage', UploadedFile::fake()->image('new-image.jpg'))
        ->call('update')
        ->assertHasNoErrors();

    Storage::disk('digitalocean')->assertMissing($storagePath);
    expect($statement->fresh()->reference_image_url)->not->toBe(fakeS3Url($storagePath));
});

it('does not delete the stored image when no new image is uploaded', function (): void {
    $storagePath = 'violation-statements/existing.jpg';
    Storage::disk('digitalocean')->put($storagePath, 'content');
    $existingUrl = fakeS3Url($storagePath);

    $statement = ViolationStatement::factory()->create([
        'reference_image_url' => $existingUrl,
    ]);

    Livewire::test(Edit::class, ['violationStatement' => $statement])
        ->call('update')
        ->assertHasNoErrors();

    Storage::disk('digitalocean')->assertExists($storagePath);
    expect($statement->fresh()->reference_image_url)->toBe($existingUrl);
});

it('nulls the reference_image_url and deletes the file when removeImage is called', function (): void {
    $storagePath = 'violation-statements/ref.jpg';
    Storage::disk('digitalocean')->put($storagePath, 'content');

    $statement = ViolationStatement::factory()->create([
        'reference_image_url' => fakeS3Url($storagePath),
    ]);

    Livewire::test(Edit::class, ['violationStatement' => $statement])
        ->call('removeImage');

    Storage::disk('digitalocean')->assertMissing($storagePath);
    expect($statement->fresh()->reference_image_url)->toBeNull();
});
