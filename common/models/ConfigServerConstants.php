<?php

namespace common\models;

class ConfigServerConstants
{
    //Local URL
    const BASE_URL_BACKEND_LOCAL = 'http://smsprosend.local'; //Backend
    const BASE_URL_FRONTEND_LOCAL = 'http://frontend_smsprosend.local'; //Frontend

    //Real Domain URL
    const BASE_URL_BACKEND = 'https://cliente.kubacel.com'; //Backend
    const BASE_URL_FRONTEND = 'https://kubacel.com'; //Frontend
//    const BASE_URL_BACKEND = 'http://smsprosend.local';
//    const BASE_URL_FRONTEND = 'http://frontend_smsprosend.local';

    //To control change languages in system
    const LANGUAGE_COOKIE_KEY_BACKEND = 'lang_cookie_back';
    const LANGUAGE_COOKIE_KEY_FRONTEND = 'lang_cookie_frontend';

    /**
     * To define Timezone of system
     * https://www.php.net/manual/en/timezones.php
     */
    const TIMEZONE = 'America/Havana';

    //To define default language of system(es, en)
    const DEFAULT_LANGUAGE = 'es'; //Spanish
    //const DEFAULT_LANGUAGE = 'en'; //English

    //To define name of system
    const SITE_NAME = 'SMS PRO SEND';
}