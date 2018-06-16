<?php


namespace common\component\Utils;


class Json {
    public static function extractStringByPath(array $data, string $jsonPath): ?string {
        $parts = explode('.', $jsonPath);
        $current = $data;
        foreach ($parts as $part) {
            preg_match('/([a-zA-Z\d\_\-]*)(\[(\d+)\]){0,1}/', $part, $matches);
            $fieldName = !empty($matches[1]) ? $matches[1] : null;
            $index = isset($matches[3]) ? (int) $matches[3] : null;

            if ($fieldName === null && $index === null) {
                throw new \Exception('Incorrect json path provided'); // @todo make eception class
            } elseif ($fieldName === null) {
                $current = $current[$index] ?? null;
            } elseif ($index === null) {
                $current = $current[$fieldName] ?? null;
            } else {
                $current = $current[$fieldName][$index] ?? null;
            }

            if ($current === null) {
                return null;
            }
        }

        if (is_string($current)) {
            return $current;
        }

        return null;
    }

    public static function extractDataByPath(array $data, string $jsonPath) {
        $parts = explode('.', $jsonPath);
        $current = $data;
        foreach ($parts as $part) {
            preg_match('/([a-zA-Z\d\_\-]*)(\[(\d+)\]){0,1}/', $part, $matches);
            $fieldName = !empty($matches[1]) ? $matches[1] : null;
            $index = isset($matches[3]) ? (int) $matches[3] : null;

            if ($fieldName === null && $index === null) {
                throw new \Exception('Incorrect json path provided'); // @todo make eception class
            } elseif ($fieldName === null) {
                $current = $current[$index] ?? null;
            } elseif ($index === null) {
                $current = $current[$fieldName] ?? null;
            } else {
                $current = $current[$fieldName][$index] ?? null;
            }

            if ($current === null) {
                return null;
            }
        }

        return $current;
    }
}