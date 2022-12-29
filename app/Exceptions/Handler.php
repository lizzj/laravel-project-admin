<?php

namespace App\Exceptions;

use App\Exceptions\Exception\DangerExceptions;
use App\Exceptions\Exception\NoticeExceptions;
use App\Exceptions\Exception\SuccessExceptions;
use App\Exceptions\Exception\WarningExceptions;
use BadMethodCallException;
use Carbon\Carbon;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Request;
use Throwable;

class Handler extends ExceptionHandler
{
    public static $type = [
        'SuccessExceptions' => 'success',
        'WarningExceptions' => 'warning',
        'NoticeExceptions' => 'info',
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \Illuminate\Database\QueryException::class,
        \Illuminate\Http\Exceptions\ThrottleRequestsException::class,
        \Illuminate\Http\Client\ConnectionException::class,
        BadMethodCallException::class,
        InvalidArgumentException::class,
        WarningExceptions::class,
        SuccessExceptions::class,
        NoticeExceptions::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse
    {
        if ($request->is('api/*')) {
            $class = endStr(get_class($e), '\\');
            switch ($class) {
                case 'SuccessExceptions':
                    $success = new SuccessExceptions($e);
                    $result = $success->dispose($e);
                    break;
                case 'WarningExceptions':
                    $warning = new WarningExceptions($e);
                    $result = $warning->dispose($e);
                    break;
                case 'AuthenticationException':
                    $arr = ['data' => ['code' => 65002]];
                    $obj = (object)$arr;
                    $warning = new WarningExceptions($e);
                    $result = $warning->dispose($obj);
                    break;
                case 'NoticeExceptions':
                    $notice = new NoticeExceptions($e);
                    $result = $notice->dispose($e);
                    break;
                default:

                    var_dump($e);
                    die();
                    $danger = new DangerExceptions();
                    $result = $danger->dispose(['code' => $e->getCode(), 'class' => $class, 'message' => 'Error']);
                    break;
            }
            $response_data = [
                'code' => $result['Code'],
                'data' => $result['Data'] ?? null,
                'message' => $result['Message'],
                'type' => $result['Type'],
                'timestamp' => Carbon::now()->timestamp
            ];
            return response()->json(arrayDetail($response_data))->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['code' => \App\Exceptions\Lang\Danger::Init(endStr(get_class($e), '\\'))['code']])->setEncodingOptions(JSON_UNESCAPED_UNICODE);
//        return parent::render($request, $e);
    }
}
