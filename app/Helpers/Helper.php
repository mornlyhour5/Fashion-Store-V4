<?php

namespace App\Helpers;

use App\Exceptions\BadRequestExcept;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Helper
{
    /**
     * Clear cached pages by tag
     *
     * @param array $catchTags
     * @return void
     */
    public static function clearCache(array $cacheTage): void
    {
        if (!empty($cacheTage)) {
            /** @var \Illuminate\Cache\TaggedCache $cacheStore */
            $cacheStore = Cache::store('redis');
            $cacheStore->tags($cacheTage)->flush();
        }
    }

    static function formatPhoneNumber($phone)
    {
        $new_num = null;
        if (empty($phone)) return null;
        $phone = trim(str_replace(' ', '', $phone));
        if (substr($phone, 0,1) == '0') {
            $new_num = '855' . substr($phone, 1, strlen($phone) - 1);
        } else if (substr($phone, 0, 3) == '855') {
            $new_num = $phone;
        } else if (substr($phone, 0, 4) == '+855') {
            $new_num = substr($phone, 1, strlen($phone) - 1);
        }
        return $new_num;
    }

    static function numLenFormat($num, $len)
    {
        if ($len <= 0) $len = 5;
        return str_pad($num, $len, '0', STR_PAD_LEFT);
    }

    static function dateYmd(string $date)
    {
        return date('Y-m-d', strtotime($date));
    }

    static function date_dmY(string $date)
    {
        return date('d-m-Y', strtotime($date));
    }

    static function dateDmy(string $date)
    {
        return date('d-M-y', strtotime($date));
    }

    static function dateYmdFormat(string $date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public static function dateTime(string $date, string $format = 'Y-m-d H:i:s'): string
    {
        $date = preg_replace('/\s+\(.*?\)/', '', $date);
        $date = str_replace('GMT', '', $date);
        $date = str_replace('0700', '+0700', $date);

        try {
            $carbon = Carbon::parse($date);
        } catch (\Exception $e) {
            throw new BadRequestExcept("Invalid date string: $date");
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($date))) {
            $carbon->setTimeFromTimeString(now()->format('H:i:s'));
        }

        $carbon->setTimezone(config('app.timezone', 'Asia/Phnom_Penh'));

        return $carbon->format($format);
    }

    public static function dateTimeFmt(string $date, string $format = 'd/m/Y h:i:s A'): string
    {
        return self::dateTime($date, $format);
    }

    /**
     * Merge an attay of key-value paire into each item of a data array
     *
     * @param array $data The array of items tp merge into.
     * @param array $mergeData The key-value  pairs to merge.
     * @param bool $forde Whether to overwrite existing keys. Defualt false.
     * @return array The resulting array with merged data.
     */
    public static function mergeIntoEach(array $data, array $mergeData, bool $force = false): array
    {
        if ($force) {
            return array_map(fn($item) => $mergeData + $item, $data);
        }

        return array_map(fn($item) => $item + $mergeData, $data);
    }

    /**
     * @param $prefix
     * @return string
     */
    public static function generateRandomCode(string $prefix, int $strLen = 8): string
    {
        $letters = strtoupper(substr(bin2hex(random_bytes(4)), 0, $strLen));

        $numbers = random_int(100000, 999999);

        return "{$prefix}-{$letters}-{$numbers}";
    }
    public static function timeHms(?string $dateTime): ?string
    {
        if (empty($dateTime)) return null;
        return date('h:i:a A', strtotime($dateTime));
    }
}
