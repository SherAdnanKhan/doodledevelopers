<?php


namespace App\Http\Services;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class BaseService
{
    protected function success($data, $message = '' , $statusCode = 200)
    {
        if ($message === '') {
            $message = trans('messages.success');
        }
        if( array_key_exists('data', $data)) {
            $data = array_merge([
                'message' => $message,
            ], $data);
        } else {

            $data = [
                'message' => $message,
                'data'    => $data
            ];
        }
        return response()->json($data, $statusCode);
    }

    protected function failure($error, $message = '', $statusCode = 422)
    {
        if ($message === '') {
            $message = trans('exception.failure');
        }
        return response()->json([
            'message' => $message,
            'error'   => $error
        ], $statusCode);
    }

    /**
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 10, $page = null, $options = []) : LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function thousandsCurrencyFormat($value) {
        if ($value < 1000) {
            return $value;
        }
        $value_number_format = number_format($value);
        $value_array = explode(',', $value_number_format);
        $value_parts = array('k', 'm', 'b', 't');
        $value_count_parts = count($value_array) - 1;
        $value_display = $value;
        $value_display = $value_array[0] . ((int) $value_array[1][0] !== 0 ? '.' . $value_array[1][0] : '');
        $value_display .= $value_parts[$value_count_parts - 1];
        return $value_display;
    }
}
