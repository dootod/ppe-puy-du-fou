<?php

class MobileMiddleware {
    public static function isMobileDevice() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $mobileKeywords = [
            'mobile', 'android', 'iphone', 'ipod', 'blackberry', 
            'webos', 'opera mini', 'windows phone', 'iemobile', 'tablet'
        ];
        
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
    
    public static function checkMobileAccess() {
        if (!self::isMobileDevice()) {
            http_response_code(403);
            // Correction du chemin
            include __DIR__ . '/Views/mobile-only.php';
            exit();
        }
    }
}