<?php
/**
 * Redirect the user no matter what. No need to use a return
 * statement. Also avoids the trap put in place by the Blade Compiler.
 *
 * @param string $url
 * @param int $code http code for the redirect (should be 302 or 301)
 */
function redirect_now($url, $code = 302)
{
	try {
		\App::abort($code, '', ['Location' => $url]);
	} catch (\Exception $exception) {
		// the blade compiler catches exceptions and rethrows them
		// as ErrorExceptions :(
		//
		// also the __toString() magic method cannot throw exceptions
		// in that case also we need to manually call the exception
		// handler
		$previousErrorHandler = set_exception_handler(function () {
		});
		restore_error_handler();
		call_user_func($previousErrorHandler, $exception);
		die;
	}
}

function page_route($code, $params = []){
    return \App\PagesService::pageRoute($code, $params);
}

function prepareFormScript($script, $elementId){
    $replaceCount = 0;

    $script = preg_replace(
        '/id="[a-z0-9_]+"/iu',
        'id="btx24_form_inline"',
        $script,1,$replaceCount);

    $script = preg_replace(
        [
            '/"node":"[#a-z0-9_]+"/iu',
            '/"node":[a-z0-9_\#\'".\(\s]+\)/iu'
        ],
        '"node": document.getElementById("'.$elementId.'")',
        $script,1,$replaceCount);

    if(!$replaceCount){
        $script = preg_replace(
            '/(b24form\([\{\}a-z0-9_\'",.:\s]+){1}(\}\)\;){1}/iu',
            '$1 ,"node": document.getElementById("'.$elementId.'") });',
            $script,1,$replaceCount);
    }

    return $script;
}