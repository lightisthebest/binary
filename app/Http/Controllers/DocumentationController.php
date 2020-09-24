<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ResponseTrait;
use Illuminate\Support\Str;
use Throwable;

class DocumentationController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        try {
            $config = config('l5-swagger');
            $file_name = Str::finish($config['defaults']['paths']['docs'], '/') . $config['documentations']['default']['paths']['docs_json'];
            $arr = array_merge($config['api-docs']['main'], [
                'paths' => $config['api-docs']['paths']
            ]);
            file_put_contents($file_name, json_encode($arr));
            return redirect('/docs');
        } catch (Throwable $e) {
            dd($e);
            return self::handleException($e);
        }
    }
}
