<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseLanguage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

/**
 * Service to manage language locales, translation files, and course language availability.
 */
class LanguageManagerService
{
    /**
     * Dictionary of predefined standard locales.
     */
    protected const PREDEFINED_LOCALES = [
        'en' => ['name' => 'English', 'native' => 'English', 'flag' => '🇺🇸'],
        'sw' => ['name' => 'Swahili', 'native' => 'Kiswahili', 'flag' => '🇹🇿'],
        'bn' => ['name' => 'Bengali', 'native' => 'বাংলা',  'flag' => '🇧🇩'],
        'es' => ['name' => 'Spanish', 'native' => 'Español', 'flag' => '🇪🇸'],
        'hi' => ['name' => 'Hindi', 'native' => 'हिन्दी',   'flag' => '🇮🇳'],
        'fr' => ['name' => 'French',  'native' => 'Français','flag' => '🇫🇷'],
        'de' => ['name' => 'German',  'native' => 'Deutsch', 'flag' => '🇩🇪'],
        'it' => ['name' => 'Italian', 'native' => 'Italiano', 'flag' => '🇮🇹'],
        'ja' => ['name' => 'Japanese','native' => '日本語',  'flag' => '🇯🇵'],
        'pt' => ['name' => 'Portuguese','native' => 'Português','flag' => '🇵🇹'],
        'ru' => ['name' => 'Russian', 'native' => 'Русский', 'flag' => '🇷🇺'],
        'zh' => ['name' => 'Chinese', 'native' => '中文',    'flag' => '🇨🇳'],
        'tr' => ['name' => 'Turkish', 'native' => 'Türkçe',  'flag' => '🇹🇷'],
    ];

    /**
     * Get list of standard predefined languages.
     */
    public function getPredefinedLocales(): array
    {
        return self::PREDEFINED_LOCALES;
    }

    /**
     * Get all supported locales based on directories in resources/lang.
     */
    public function getSupportedLocales(): array
    {
        $langDir = resource_path('lang');
        $locales = [];

        if (File::isDirectory($langDir)) {
            $directories = File::directories($langDir);
            foreach ($directories as $dirPath) {
                $code = basename($dirPath);

                // Explicitly ignore vendor folder and hidden folders
                if ($code === 'vendor' || str_starts_with($code, '.')) {
                    continue;
                }

                $locales[$code] = self::PREDEFINED_LOCALES[$code] ?? [
                    'name' => strtoupper($code),
                    'native' => strtoupper($code),
                    'flag' => '🏳️',
                ];
            }
        }

        // Sort by name
        uasort($locales, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $locales;
    }

    /**
     * Get all translation files (groups) for a locale.
     */
    public function getTranslationFiles(string $locale): array
    {
        $localeDir = resource_path("lang/{$locale}");
        $groups = [];

        if (File::isDirectory($localeDir)) {
            $files = File::files($localeDir);
            foreach ($files as $file) {
                if ($file->getExtension() === 'php') {
                    $groups[] = $file->getBasename('.php');
                }
            }
        }

        sort($groups);
        return $groups;
    }

    /**
     * Load translations from a specific file.
     */
    public function getTranslations(string $locale, string $group): array
    {
        $path = resource_path("lang/{$locale}/{$group}.php");

        if (File::exists($path)) {
            try {
                $translations = File::getRequire($path);
                if (is_array($translations)) {
                    return $translations;
                }
            } catch (\Throwable $e) {
                // Return empty if file is corrupt or unreadable
            }
        }

        return [];
    }

    /**
     * Save translations back to a PHP array file.
     */
    public function saveTranslations(string $locale, string $group, array $translations): bool
    {
        $path = resource_path("lang/{$locale}/{$group}.php");

        // Ensure directory exists
        $dir = dirname($path);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // Sort translations by key to keep files organized
        ksort($translations);

        $content = "<?php\n\nreturn " . $this->formatArray($translations) . ";\n";

        File::put($path, $content);

        // Invalidate OPcache for this file if OPcache is active
        if (function_exists('opcache_invalidate')) {
            @opcache_invalidate($path, true);
        }

        // Clear active locales cache to keep everything in sync
        Cache::forget('active_system_locales');

        return true;
    }

    /**
     * Add a translation key to all locales to keep them in sync.
     */
    public function addKeyToAllLocales(string $group, string $key, string $defaultValue): void
    {
        $locales = $this->getSupportedLocales();

        foreach ($locales as $code => $data) {
            $translations = $this->getTranslations($code, $group);

            // Don't overwrite if key already exists
            if (!array_key_exists($key, $translations)) {
                $translations[$key] = $defaultValue;
                $this->saveTranslations($code, $group, $translations);
            }
        }
    }

    /**
     * Create a new language and initialize files from English.
     */
    public function createLanguage(string $code): bool
    {
        $targetDir = resource_path("lang/{$code}");

        if (File::isDirectory($targetDir)) {
            return false;
        }

        File::makeDirectory($targetDir, 0755, true);

        // Copy all template files from 'en'
        $sourceDir = resource_path('lang/en');
        if (File::isDirectory($sourceDir)) {
            $files = File::files($sourceDir);
            foreach ($files as $file) {
                if ($file->getExtension() === 'php') {
                    File::copy($file->getPathname(), $targetDir . '/' . $file->getFilename());
                }
            }
        }

        // Sync into course_languages table so one unified language list serves both UI & courses
        $meta = self::PREDEFINED_LOCALES[$code] ?? [
            'name' => strtoupper($code),
            'native' => strtoupper($code),
        ];
        CourseLanguage::updateOrCreate(
            ['code' => $code],
            [
                'name' => $meta['name'],
                'native_name' => $meta['native'],
                'is_active' => true,
            ]
        );

        // Clear cache
        Cache::forget('active_system_locales');

        return true;
    }

    /**
     * Toggle whether a system language is active in the course catalog dropdown.
     */
    public function toggleCourseAvailability(string $code): bool
    {
        $code = strtolower($code);
        $courseLang = CourseLanguage::where('code', $code)->first();

        if ($courseLang) {
            $courseLang->is_active = !$courseLang->is_active;
            $courseLang->save();

            return $courseLang->is_active;
        }

        $meta = self::PREDEFINED_LOCALES[$code] ?? [
            'name' => strtoupper($code),
            'native' => strtoupper($code),
        ];

        CourseLanguage::create([
            'code' => $code,
            'name' => $meta['name'],
            'native_name' => $meta['native'],
            'is_active' => true,
            'display_order' => (int) CourseLanguage::max('display_order') + 1,
        ]);

        return true;
    }

    /**
     * Delete a language directory and detach/remove its course language entry.
     */
    public function deleteLanguage(string $code): bool
    {
        if ($code === 'en' || $code === 'vendor') {
            return false;
        }

        $dir = resource_path("lang/{$code}");
        $deleted = false;

        if (File::isDirectory($dir)) {
            File::deleteDirectory($dir);
            $deleted = true;
        }

        $courseLang = CourseLanguage::where('code', $code)->first();
        if ($courseLang) {
            Course::where('course_language_id', $courseLang->id)
                ->update(['course_language_id' => null]);
            $courseLang->delete();
            $deleted = true;
        }

        if ($deleted) {
            Cache::forget('active_system_locales');
        }

        return $deleted;
    }

    /**
     * Recursively format array to PHP short syntax representation with proper indentation.
     */
    protected function formatArray(array $array, int $indent = 1): string
    {
        $indentStr = str_repeat('    ', $indent);
        $closeIndentStr = str_repeat('    ', $indent - 1);
        $parts = [];

        foreach ($array as $key => $value) {
            $keyEscaped = addcslashes($key, "'\\");
            if (is_array($value)) {
                $parts[] = "{$indentStr}'{$keyEscaped}' => " . $this->formatArray($value, $indent + 1) . ",";
            } else {
                $valueEscaped = addcslashes((string) $value, "'\\");
                $parts[] = "{$indentStr}'{$keyEscaped}' => '{$valueEscaped}',";
            }
        }

        return "[\n" . implode("\n", $parts) . "\n{$closeIndentStr}]";
    }
}
