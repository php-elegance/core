<?php

if (!function_exists('build_url')) {

    /** Cria uma string de URL basando-se em um array parse_url */
    function build_url(array $parts): string
    {
        $scheme = !is_blank($parts['scheme'] ?? '') ? $parts['scheme'] : null;
        $host = !is_blank($parts['host'] ?? '') ? $parts['host'] : null;
        $port = !is_blank($parts['port'] ?? '') ? $parts['port'] : null;

        $auth = null;
        $user = !is_blank($parts['user'] ?? '') ? $parts['user'] : null;
        $pass = !is_blank($parts['pass'] ?? '') ? $parts['pass'] : null;

        $path = !is_blank($parts['path'] ?? '') ? $parts['path'] : null;
        $query = !is_blank($parts['query'] ?? '') ? $parts['query'] : null;

        $fragment = !is_blank($parts['fragment'] ?? '') ? $parts['fragment'] : null;

        if (!is_blank($scheme))
            $scheme = strtolower($scheme) . '://';

        if (!is_blank($port))
            $port = ":$port";

        if ($port == ':80')
            $port = '';

        if (!is_blank($user))
            $auth = is_blank($pass) ? "$user@" : "$user:$pass@";

        if (!is_blank($path))
            $path = is_array($path) ? path("/", ...$path) : path("/$path");

        if (!is_blank($query) && is_array($query))
            $query = '?' . urldecode(http_build_query($query));

        if (!is_blank($fragment))
            $fragment = "#$fragment";

        return $scheme . $auth . $host . $port . $path . $query . $fragment;
    }
}
