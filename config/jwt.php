<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Secret Key
    |--------------------------------------------------------------------------
    */

    'key' => env('JWT_KEY', 'key'),

    /*
    |--------------------------------------------------------------------------
    | Issuer Claim
    |--------------------------------------------------------------------------
    | The "iss" (issuer) claim identifies the principal that issued the
    | JWT.  The processing of this claim is generally application specific.
    | The "iss" value is a case-sensitive string containing a StringOrURI
    | value.  Use of this claim is OPTIONAL.
    */

    'iss' => env('JWT_ISSUER', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Issued At Claim
    |--------------------------------------------------------------------------
    | The "iat" (issued at) claim identifies the time at which the JWT was
    | issued.  This claim can be used to determine the age of the JWT.  Its
    | value MUST be a number containing a NumericDate value.  Use of this
    | claim is OPTIONAL.
    */

    'iat' => time(),

    /*
    |--------------------------------------------------------------------------
    | Not Before Claim
    |--------------------------------------------------------------------------
    | The "nbf" (not before) claim identifies the time before which the JWT
    | MUST NOT be accepted for processing.  The processing of the "nbf"
    | claim requires that the current date/time MUST be after or equal to
    | the not-before date/time listed in the "nbf" claim.  Implementers MAY
    | provide for some small leeway, usually no more than a few minutes, to
    | account for clock skew.  Its value MUST be a number containing a
    | NumericDate value.  Use of this claim is OPTIONAL.
    */

    'nbf' => time(),

    /*
    |--------------------------------------------------------------------------
    | Expiration Time Claim
    |--------------------------------------------------------------------------
    | The "exp" (expiration time) claim identifies the expiration time on
    | or after which the JWT MUST NOT be accepted for processing.  The
    | processing of the "exp" claim requires that the current date/time
    | MUST be before the expiration date/time listed in the "exp" claim.
    */

    'exp' => time() + 960,
];