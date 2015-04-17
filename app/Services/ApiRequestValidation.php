<?php namespace Butler\Services;

use Illuminate\Http\Request;

class ApiRequestValidation
{

    public static function validate(Request $request, $app_secret)
    {
        $contentHash = $request->header('X-Hash');
        $content = $request->getContent();

        $hash = hash_hmac('sha256', $content, $app_secret);

        return $hash === $contentHash;
    }
}