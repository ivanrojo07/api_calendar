<?php

namespace App\Exceptions;
use App\Traits\ApiResponser;
use Asm89\Stack\CorsService;
use Illuminate\Database\QueryException;
use App\Exceptions\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponser;
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
     * @throws \Throwable
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
    public function render($request, Throwable $exception)
    {
        
        if ($exception instanceof ModelNotFoundException) {
            $modelo = strtolower(class_basename($exception->getModel()));
           return $this->errorResponse('No existe ninguna instancia de '.$modelo. ' con el Id especificado',404);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        }
        if ($exception instanceof AuthorizationException){
            return $this->errorResponse('No posee permisos para ejecutar esta accion', 403);
        }
         if ($exception instanceof NotFoundHttpException){
            return $this->errorResponse('No se encontro la URL especificada', 403);
        }
         if ($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('El metodo especificado en la peticion no es valido', 403);
        }
         if ($exception instanceof HttpException){
            return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }
         if ($exception instanceof QueryException){
            $codigo=$exception->errorInfo[1];
            if ($codigo==1451) {
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso porque esta relacionado con algun otro.',409);
            }
           // return $this->errorResponse($exception->getMessage(),$exception->getStatusCode());
        }

        return parent::render($request, $exception);
    }





}
