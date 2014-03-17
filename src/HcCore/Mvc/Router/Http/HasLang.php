<?php
namespace HcCore\Mvc\Router\Http;

use Zend\Mvc\Router\Exception;
use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\Stdlib\RequestInterface as Request;

/**
 * HasLang route type.
 */
class HasLang extends Literal
{
    /**
     * @param string $path
     * @return null|RouteMatch
     */
    protected function checkPathByRegex($path)
    {
        $match = '/^'.preg_quote($this->route,'/').'(([a-z]{2})(\-([a-zA-Z]{2}))?)(\/|$)'.'/';
        if (preg_match($match, $path, $matches)) {
            $this->defaults['lang'] = $matches[1];
            return new RouteMatch($this->defaults, strlen($matches[0]));
        }

        return null;
    }

    /**
     * @param Request $request
     * @param null $pathOffset
     * @return null|RouteMatch
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (!method_exists($request, 'getUri')) {
            return null;
        }

        $uri  = $request->getUri();
        $path = $uri->getPath();

        if ($pathOffset !== null) {
            if ($pathOffset >= 0 && strlen($path) >= $pathOffset && !empty($this->route)) {
                if ($match = $this->checkPathByRegex(substr($path, $pathOffset))) {
                    return $match;
                } else if (strpos($path, $this->route, $pathOffset) === $pathOffset) {
                    return new RouteMatch($this->defaults, strlen($this->route));
                }
            }
            return null;
        }

        if ($path === $this->route) {
            return new RouteMatch($this->defaults, strlen($this->route));
        }

        if ($match = $this->checkPathByRegex($path)) {
            return $match;
        }

        return null;
    }

    /**
     * @param array $params
     * @param array $options
     * @return mixed|string
     */
    public function assemble(array $params = array(), array $options = array())
    {
        if (array_key_exists('lang', $this->defaults) &&
            !empty($this->defaults['lang']) && strlen($this->defaults['lang'])) {
            $lang = $this->defaults['lang'].'/';
        } else {
            $lang = '';
        }

        return $this->route.$lang;
    }
}
