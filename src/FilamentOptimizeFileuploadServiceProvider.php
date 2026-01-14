<?php

namespace Agencetwogether\FilamentOptimizeFileupload;

use Closure;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Exceptions\EncoderException;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;
use League\Flysystem\UnableToCheckFileExistence;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentOptimizeFileuploadServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-optimize-fileupload';

    public static string $viewNamespace = 'filament-optimize-fileupload';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->askToStarRepoOnGitHub('agencetwogether/filament-optimize-fileupload');
            });
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        FileUpload::macro('optimize', function (string|Closure|null $format = null, string|Closure|null $quality = null): static {

            $this->saveUploadedFileUsing(static function (FileUpload $component, TemporaryUploadedFile $file) use ($format, $quality): ?string {
                try {
                    if (! $file->exists()) {
                        return null;
                    }
                } catch (UnableToCheckFileExistence $exception) {
                    return null;
                }

                // //////////Code Added

                if (
                    str_contains($file->getMimeType(), 'image')
                    && filled($format)
                ) {

                    $format = $component->evaluate($format);
                    $quality = $component->evaluate($quality);

                    $desiredFormat = Format::tryCreate($format);

                    if (filled($desiredFormat)) {

                        $filename = $component->getUploadedFileNameForStorage($file);

                        $manager = ImageManager::withDriver(new Driver);

                        $image = $manager->read($file);

                        $extension = $desiredFormat->fileExtension()->value;

                        if (filled($quality) && is_numeric($quality)) {
                            $encoder = $desiredFormat->encoder(quality: intval($quality));
                        } else {
                            $encoder = $desiredFormat->encoder();
                        }

                        $encodedFile = $image->encode($encoder);

                        $filename = generateFilename_filament_optimize($filename, $extension);

                        Storage::disk($component->getDiskName())->put(
                            $component->getDirectory().'/'.$filename,
                            $encodedFile
                        );

                        return $component->getDirectory().'/'.$filename;

                    } else {
                        throw new EncoderException('No encoder found for file extension ('.$format.').');
                    }

                }
                // //////////

                if (
                    $component->shouldMoveFiles() &&
                    ($component->getDiskName() === (fn (): string => $this->disk)->call($file))
                ) {
                    $newPath = trim($component->getDirectory().'/'.$component->getUploadedFileNameForStorage($file), '/');

                    $component->getDisk()->move((fn (): string => $this->path)->call($file), $newPath);

                    return $newPath;
                }

                $storeMethod = $component->getVisibility() === 'public' ? 'storePubliclyAs' : 'storeAs';

                return $file->{$storeMethod}(
                    $component->getDirectory(),
                    $component->getUploadedFileNameForStorage($file),
                    $component->getDiskName(),
                );
            });

            return $this;
        });
    }
}
