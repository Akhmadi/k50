<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class PagesService {

	/**
	 * Get routes info from all pages or page by code or page object
	 *
	 * @param null $code
	 *
	 * @return array
	 */
	public static function getRoutesByPages($code = null){

		$pages = Cache::remember('pages', 180, function(){
			return Page::all();
		});

		if ($code) {
			if (is_string($code)) {
				$pages = $pages->where('code', '=', $code)->all();
			} else {
				$pages = [$code];
			}
		}

		$routes = [];

		foreach ( $pages as $page) {

			$routes[] = [
				'route' => trim($page->url, '/'),
				'info'  => [],
				'page' => $page
			];

		}

		$filledRoutes = array_map(function($r){
			$r['info'] = self::getRegExpUrlInfo($r['route']);
			return $r;
		}, $routes);

		return $filledRoutes;
	}


	/**
	 * Match url by patterns and return route info
	 *
	 * @param $url
	 *
	 * @return mixed|null
	 */
	public static function getRouteByUrl($url){

		$urlSegments = explode('/', $url);

		$filledRoutes = self::getRoutesByPages();

		foreach ($filledRoutes as $route){

			if ($result = preg_match($route['info']['pattern'], $url, $match)){

				if (count($route['info']['params'])) {
					foreach ( $route['info']['params'] as &$param ) {
						$param['value'] = isset($urlSegments[$param['index']])
							? $urlSegments[$param['index']]
							: null;
					}
				}

				return $route;
			}
		}

		return null;
	}

	/**
	 * Get url info(regexp pattern, params, segments)
	 *
	 * @param $url
	 *
	 * @return array
	 */
	public static function getRegExpUrlInfo($url){

		$segments = explode('/', $url);
		$regexpUrl = [];
		$urlParams = [];
		$urlSegments = [];
		$defaultPattern = '[а-яa-z0-9-_]+';

		foreach ($segments as $key => $segment){

			if (starts_with($segment, ':')) {
				$pattern = $defaultPattern;

				if (strpos($segment, '|')) {
					$segmentData = explode('|',$segment);

					$segment = $segmentData[0];
					$pattern = $segmentData[1];
				}

				if (ends_with($segment, '?')){
					$pattern = '(\/'.$pattern.')?';
				}

				$segment = trim($segment, ':?');

				$regexpUrl[] = $pattern;
				$urlParams[$segment] = [
					'index' => $key,
					'name' => $segment
				];

				$urlSegments[] = [ 'type' => 'param', 'value' => $segment ];

			} else {
				$regexpUrl[] = $segment;
				$urlSegments[] = [ 'type' => 'static', 'value' => $segment ];
			}
		}

		$regexpUrl = '/^'.implode('\/', $regexpUrl).'$/i';

		$regexpUrl = str_replace('\/(','(', $regexpUrl);

		return [
			'pattern' => $regexpUrl,
			'params' => $urlParams,
			'segments' => $urlSegments
		];
	}

	/**
	 * Get relative url by page code and params
	 *
	 * @param string|object $code
	 * @param array $params
	 *
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public static function pageRoute($code, $params = []){

		$filledRoutes = self::getRoutesByPages($code);

		if (count($filledRoutes)){

			$result = [];

			$segments = $filledRoutes[0]['info']['segments'];
			$paramsKeys = array_keys($params);

			foreach ( $segments as $segment ) {
				if ($segment['type'] == 'static') {
					$result[] = $segment['value'];
				} else {
					if ($segment['type'] == 'param' && in_array($segment['value'], $paramsKeys)) {
						$result[] = $params[$segment['value']];
					}
				}
			}

			return url(implode('/', $result));
		} else {
			return '';
		}
	}
}