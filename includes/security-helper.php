<?php
/**
 * Simple Security Helper for Input Sanitization
 */

class SecurityHelper {
    
    /**
     * Sanitize string input - removes harmful characters
     */
    public static function sanitizeString($input, $maxLength = 255) {
        if (empty($input)) return '';
        
        // Remove null bytes and trim whitespace
        $input = str_replace(chr(0), '', trim($input));
        
        // Limit length
        if ($maxLength > 0) {
            $input = substr($input, 0, $maxLength);
        }
        
        // Convert special characters to HTML entities
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    
    /**
     * Sanitize email input
     */
    public static function sanitizeEmail($email) {
        $email = trim($email);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
    }
    
    /**
     * Sanitize integer input
     */
    public static function sanitizeInt($input, $min = null, $max = null) {
        $int = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        $int = (int) $int;
        
        if ($min !== null && $int < $min) return false;
        if ($max !== null && $int > $max) return false;
        
        return $int;
    }
    
    /**
     * Sanitize URL input
     */
    public static function sanitizeUrl($url) {
        $url = trim($url);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return filter_var($url, FILTER_VALIDATE_URL) ? $url : false;
    }
    
    /**
     * Validate password strength
     */
    public static function validatePassword($password) {
        if (strlen($password) < 6) {
            return "Wachtwoord moet minimaal 6 karakters zijn";
        }
        return true;
    }
    
    /**
     * Secure password hashing
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Clean filename for uploads
     */
    public static function sanitizeFilename($filename) {
        $filename = basename($filename);
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
        return substr($filename, 0, 255);
    }
    
    /**
     * Validate user role
     */
    public static function validateRole($role) {
        $validRoles = ['member', 'admin'];
        return in_array($role, $validRoles) ? $role : 'member';
    }
    
    /**
     * Clean text content (for descriptions, etc.)
     */
    public static function sanitizeText($text, $maxLength = 1000) {
        if (empty($text)) return '';
        
        // Remove null bytes and excessive whitespace
        $text = str_replace(chr(0), '', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));
        
        // Limit length
        if ($maxLength > 0) {
            $text = substr($text, 0, $maxLength);
        }
        
        // Convert special characters
        return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}
?>