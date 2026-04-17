<?php

declare(strict_types=1);

namespace Spatie\MediaLibraryPro\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Compatibility shim for removed spatie/laravel-medialibrary-pro TemporaryUpload model.
 * Referenced by config/media-library.php; kept so the config can still load.
 */
class TemporaryUpload extends Model {}
