<?php

namespace App\Parsers;

use \Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * CriteriaParser
 *
 * @category Parsers
 * @package  App
 * @author   Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
class CriteriaParser
{
    /** @var array */
    const CRITERIA_FIELDS = [
        'filter',
        'filters',
        'search',
        'orderBy',
        'with',
        'has'
    ];
    /**
     * parseQueryString
     * Parse Query String into a array splitted by '&'
     *
     * @param  mixed $str
     * @param  mixed $delimiter
     * @return array
     */
    public static function parseQueryString($str, $delimiter = '&'): array
    {
        if ($str[0] == '?') {
            $str = substr($str, 1);
        }

        return collect(explode($delimiter, $str))
            ->reduce(
                function ($body, $query) {
                    list($key, $value) = explode('=', $query);
                    $body[$key] = $value;
                    return $body;
                },
                []
            );
    }

    /**
     * parseString
     *
     * @param  string $str
     * @param  string $key
     * @param  string $delimiter
     *
     * @return array
     */
    public static function parseString(string $str, string $key = 'search', string $delimiter = '&'): array
    {
        $key_start_index = strpos($str, $key);
        $key_end_index = strpos($str, $delimiter, $key_start_index);

        if ($key_end_index === false) {
            $key_end_index = strlen($str);
        } else {
            $key_end_index -= 1;
        }

        $search = str_replace(
            "{$key}=",
            '',
            substr($str, $key_start_index, $key_end_index)
        );

        return self::parseSearch($search);
    }

    /*
    *
    * @param
    * @param string $request
    * @return array
    */
    /**
     * Parse HTTP Request string input $key
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $key
     *
     * @return array
     */
    public static function parseRequest(Request $request): array
    {
        return self::parseParams($request->query());
    }

    /**
     * parseParams
     *
     * @param  mixed $params
     *
     * @return array
     */
    public static function parseParams(array $params = []): array
    {
        $values = collect(array_filter(Arr::only($params, self::CRITERIA_FIELDS)));

        return $values->map(
            function ($value, $key) {
                return self::parseField($value, $key);
            }
        )->toArray();
    }

    /**
     * parseField
     *
     * @param  string $value
     * @param  string $key
     *
     * @return array
     */
    public static function parseField(string $value, string $key): array
    {
        switch ($key) {
            case 'orderBy':
                return self::parseOrderBy($value);
                break;
            case 'filters':
            case 'filter':
            case 'search':
                return self::parseSearch($value);
                break;
            case 'with':
            case 'has':
            case 'field':
                return self::parseByComma($value);
                break;
        }
        return array_filter(explode(';', $value));
    }

    /**
     * parseByComma
     *
     * @param  string $values
     *
     * @return array
     */
    public static function parseByComma(string $values): array
    {
        return array_filter(explode(',', $values));
    }

    /**
     * parseOrderBy
     *
     * @param  mixed $orderBy
     *
     * @return array
     */
    public static function parseOrderBy(string $orderBy): array
    {
        if (!stripos($orderBy, ':')) {
            return [];
        }
        return collect(explode(';', $orderBy))
            ->reduce(
                function ($body, $field) {
                    try {
                        list($field, $value) = explode(':', $row);
                        $body[$field] = stripos($value, ',') ? explode(',', $value) : $value;
                    } catch (\Exception $e) {
                    }
                    return $body;
                },
                []
            );
    }

    /**
     * parseSearch
     * Parse search string into an array splitted by colon (;) with $key : $value pair
     *
     * @param  mixed $search
     * @return array
     */
    public static function parseSearch(string $search): array
    {
        if (!stripos($search, ':')) {
            return [];
        }
        return collect(explode(';', $search))
            ->reduce(
                function ($body, $row) {
                    list($field, $value) = explode(':', $row);
                    $body[$field] = $value;
                    return $body;
                },
                []
            );
    }
}
