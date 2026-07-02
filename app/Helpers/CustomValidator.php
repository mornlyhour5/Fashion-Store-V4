<?php

namespace App\Helpers;

use App\Exceptions\BadRequestExcept;
use App\Exceptions\ValidationExcept;
use Illuminate\Support\Facades\Validator;

class CustomValidator
{
    /**
     * Validate and sanitize data.
     *
     * @param array $data Input data
     * @param array $rules Laravel validation rules
     * @param array $allowedTagsPerField Allowed HTML tags per field, e.g., ['description' => ['b', 'i']]
     * @param bool $throwOnDisallowed Throw exception if disallowed HTML exists
     * @return array Validated and sanitized data
     * @throws BadRequestExcept
     */
    public static function validate(
        array $data,
        array $rules,
        array $allowedTagePerFields = [],
        array $booleanFields = [],
        bool $throwOnDisallowed = false,
        ?array $attrs = [],
        array | string $contexts = []
    ): array {
        $sanitized = self::sanitize(
            data: $data,
            allowedTagsPerField: $allowedTagePerFields,
            throwOnDisallowed: $throwOnDisallowed,
            booleanFields: $booleanFields
        );

        $contexts = (array)$contexts;
        $allMessages = trans('validation.custom');
        $messages = $allMessages['purchase'] ?? [];

        foreach ($contexts as $context) {
            $nestedmessage = $allMessages[$context] ?? [];
            $messages = array_merge($messages, self::flattenMessages($nestedmessage));
        }

        $validator = Validator::make(
            data: $sanitized,
            rules: $rules,
            messages: $messages,
            attributes: $attrs
        );

        if ($validator->fails()) {
            throw new ValidationExcept($validator->errors()->first());
        }

        return $validator->validated();
    }

    /**
    Recursively sanitize input data
    *
    * @param array $data
    * @param array $allowedTagsPerField
    * @param bool $throwOnDisallowed
    * @return array
    * @throws BadRequestExcept
    */

    public static function sanitize(array $data, array $allowedTagsPerField = [], array $booleanFields = [], bool $throwOnDisallowed = false): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = self::sanitize(
                    data: $value,
                    allowedTagsPerField: $allowedTagsPerField,
                    booleanFields: $booleanFields,
                    throwOnDisallowed: $throwOnDisallowed
                );
                continue;
            }

            if (in_array($key, $booleanFields, true)) {
                $value = self::toBool($value);
            }

            if (!is_string($value)) {
                $sanitized[$key] = $value;
                continue;
            }

            $allowedTags = $allowedTagsPerField[$key] ?? [];

            if (empty($allowedTags)) {
                $sanitized[$key] = $value;
                continue;
            }

            $allowedTagesString = '<' . implode('><', $allowedTags) . '>';
            $clean = strip_tags($value, $allowedTagesString);
            $clean = preg_replace('/(<[^>]+)\s*on[a-z]+\s*=\s*["\'][^"\']*["\']/', '$1', $clean);
            $clean = preg_replace('/javascript:/i', '', $clean);

            if ($throwOnDisallowed && $clean !== $value) {
                throw new BadRequestExcept("Field '{$key}' contains disallowed HTML or sripts");
            }

            $sanitized[$key] = $clean;
        }

        return $sanitized;
    }

    /**
     * Convert common boolean-like values to real boolean.
     *
     * @param mixed $value
     * @return bool
     * @throws BadRequestExcept
     */
    static function toBool(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value)) {
            if ($value === 1) return true;
            if ($value === 0) return false;
        }

        if (is_string($value)) {
            $value = strtolower(trim($value));

            if ($value === 'true' || $value === '1') {
                return true;
            }

            if ($value === 'false' || $value === '0') {
                return false;
            }
        }

        throw new BadRequestExcept('Invalid boolean value');
    }

    protected static function flattenMessages(array $messages, string $prefix = ''): array
    {
        $result = [];

        foreach ($messages as $key => $value) {
            $fullkey = $prefix ? "{$prefix}.{$key}" : $key;

            if (is_array($value)) {
                $result = array_merge($result, self::flattenMessages($value, $fullkey));
            } else {
                $result[$fullkey] = $value;
            }
        }
        return $result;
    }
}
