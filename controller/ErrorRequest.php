<?php
    function errorResponse($code) {
        http_response_code($code);
        return "Error $code";
    }