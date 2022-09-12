<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

use App\Models\PageModel;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    // public function render($request, Throwable $exception)
    // {
    //     return parent::render($request, $exception);
    // }
    public function render($request, Throwable $exception)
    {
        // echo $exception->getStatusCode();
        // dd($exception);

        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                $dataArr = PageModel::getData(7, '', 2);
                if (!empty($dataArr)) {
                    $dataArr['full_url'] = $request->fullUrl();

                    $meta_title = $dataArr['meta_title'];
                    $dataArr['meta_title'] = $meta_title != '' ? strip_tags($meta_title) : strip_tags($dataArr['title']);
                    $meta_descp = $dataArr['meta_descp'];
                    $dataArr['meta_descp'] = $meta_descp != '' ? strip_tags($meta_descp) : strip_tags($dataArr['descp']);

                    $appTitle = Config('app.name');
                    $defDataArr = array("def_img_ttl" => $appTitle, "def_img_alt" => $appTitle);

                    return response()->view('themes.frontend.pages.404', compact('defDataArr', 'dataArr'));
                }
            }
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }
        return redirect()->guest(route('web.login'));
    }
}
