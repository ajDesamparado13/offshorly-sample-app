<?php

namespace App\Http\Requests;

use App\Parsers\CriteriaParser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class IndexTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * all
     *
     * @param  mixed $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $params = parent::all($keys);
        if (Arr::hasAny($params, CriteriaParser::CRITERIA_FIELDS)) {
            foreach (CriteriaParser::parseRequest($this) as $criteria => $param) {
                $params[$criteria] = $param;
            }
        }
        return $params;
    }
}
