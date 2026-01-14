<?php

if (! function_exists('generateFilename_filament_optimize')) {
    function generateFilename_filament_optimize(string $filename, ?string $format): string
    {
        if (! $format) {
            return $filename;
        }

        $extension = strrpos($filename, '.');

        if ($extension !== false) {
            return substr($filename, 0, $extension + 1) . $format;
        }

        return $filename;
    }
}
