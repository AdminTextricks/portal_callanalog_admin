<?php 

// session_name('CallAnalog');
session_start();

// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// error_reporting(E_NOTICE);
$connection = mysqli_connect("localhost", "root", "tumko34h1se","myphonesystem");

$con = mysqli_connect("localhost", "root", "tumko34h1se","myphonesystem");

$extension_numbers = array('1','2','3','4','5','10','15','20','50');

$numberpool = array('800','833','844','855','866','877','888');

$user_type_arr = array(1=>'Admin', 2=>'User', 3=>'Reseller', 4=>'Reseller_User');

define('PUBLIC_KEY','/var/www/.ssh/id_rsa.pub');

define('PRIVATE_KEY','/var/www/.ssh/id_rsa');

define('RHOST','37.61.219.110');

define('RPORT','19645');

//define('SECOND_PUBLIC_KEY','/var/www/.ssh/id_rsa2.pub');
//define('SECOND_PRIVATE_KEY','/var/www/.ssh/id_rsa2');
//define('SECOND_RHOST','85.195.76.161');
//define('SECOND_RPORT','17342');
//define('SECOND_RUSERNAME','opnsipusr');

define('SECOND_PUBLIC_KEY','/var/www/.ssh/id_rsa.pub');
define('SECOND_PRIVATE_KEY','/var/www/.ssh/id_rsa');
define('SECOND_RHOST','37.61.219.110');
define('SECOND_RPORT','19645');
define('SECOND_RUSERNAME','asteruser');


define('RUSERNAME','asteruser');

// define('RPASSWORD','NDJNMpg8553T');

define('RPASSWORD','{Tfmx;O5Ar2;hp;%-vj]%3--$nBb6S');

// define('HOST','bom1plzcpnl494593.prod.bom1.secureserver.net');
define('HOST','smtp.gmail.com');

define('RECORDINGS','https://portal-myphonesystems-recordings.s3.ap-south-1.amazonaws.com/');

define('PORT',587);

// define('IPDOMAIN','37.61.219.110:50070');

define('IPDOMAIN','sip.callanalog.com:50070');


// define('EMAIL','info@myphonesystems.com');
// define('EMAIL','ankit@textricks.com');
define('EMAIL','info@callanalog.com');

// define('PASSWORD','myphonesystems@123');
define('PASSWORD','amkomuqebcfvuebp');

define('MYPHONE','Call Analog');

define('ACCOUNTSID','ACede26b49f6397ebfa1ce13d4f2ee334c');

define('AUTHTOKEN','4c3f97db3fcbf0e9ee1b714152082e85');

define('TWILLONUMBER','+18885468422');

// define('SECRET_KEY','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');

// define('PUBLISHABLE_KEY','pk_live_51JHZjxG71L2aH3X1DB6IwwPkiYZ3Bq0WN2I1RXjggZ3LDr8Sa5MJMOatI0Ha8jaUvcWUD1rCOCMlpVKrggPVQRFw00xi47rZgH');


// define('SECRET_KEY', 'sk_test_51JHZjxG71L2aH3X1s51mMhtoNHR4OLjmz3aIon30blNltbjw2Pu7DOmh4FbBi2502vGlYgEfNB8x1xaxKnLEnLW2000ZTC5Z3r');
// define('PUBLISHABLE_KEY', 'pk_test_51JHZjxG71L2aH3X16DtsCw8NhYxYGQv9IK41nlvjqmtlM3yoha3LqgQcjHvC81fqdknutLgFPf4EJj2UXPMIVRPP00fPbxse74');

//define('SECRET_KEY', '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');
//define('PUBLISHABLE_KEY', 'pk_live_51JHZjxG71L2aH3X1DB6IwwPkiYZ3Bq0WN2I1RXjggZ3LDr8Sa5MJMOatI0Ha8jaUvcWUD1rCOCMlpVKrggPVQRFw00xi47rZgH');

 define('SECRET_KEY', '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');
 define('PUBLISHABLE_KEY', 'pk_live_51JHZjxG71L2aH3X1DB6IwwPkiYZ3Bq0WN2I1RXjggZ3LDr8Sa5MJMOatI0Ha8jaUvcWUD1rCOCMlpVKrggPVQRFw00xi47rZgH');

 //define('STRIPE_API_KEY', 'sk_test_51JHZjxG71L2aH3X1s51mMhtoNHR4OLjmz3aIon30blNltbjw2Pu7DOmh4FbBi2502vGlYgEfNB8x1xaxKnLEnLW2000ZTC5Z3r'); 
 //define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51JHZjxG71L2aH3X16DtsCw8NhYxYGQv9IK41nlvjqmtlM3yoha3LqgQcjHvC81fqdknutLgFPf4EJj2UXPMIVRPP00fPbxse74'); 
 
 define('STRIPE_API_KEY', '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'); 
 define('STRIPE_PUBLISHABLE_KEY', 'pk_live_51JHZjxG71L2aH3X1DB6IwwPkiYZ3Bq0WN2I1RXjggZ3LDr8Sa5MJMOatI0Ha8jaUvcWUD1rCOCMlpVKrggPVQRFw00xi47rZgH'); 
 
//  define('STRIPE_API_KEY', 'sk_test_51JHZjxG71L2aH3X1s51mMhtoNHR4OLjmz3aIon30blNltbjw2Pu7DOmh4FbBi2502vGlYgEfNB8x1xaxKnLEnLW2000ZTC5Z3r'); 
// define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51JHZjxG71L2aH3X16DtsCw8NhYxYGQv9IK41nlvjqmtlM3yoha3LqgQcjHvC81fqdknutLgFPf4EJj2UXPMIVRPP00fPbxse74'); 

define('SIP_TEMPLATE_CONTENT', 'type=friend
host=dynamic
trustrpid=yes
outofcall_message_context=from-web
auth_message_requests=yes
accept_outofcall_message=yes
context=textricks-outcall
sendrpid=no
qualify=yes
canreinvite=no
qualifyfreq=600
transport=udp,tcp
directmedia=no
disallow=all
allow=ulaw,g729,alaw
nat=force_rport,comedia');


$did_provider = array(
    'IDT','ALZ'
);

$timezones = array(
    'Africa/Abidjan',
    'Africa/Accra',
    'Africa/Addis_Ababa',
    'Africa/Algiers',
    'Africa/Asmara',
    'Africa/Bamako',
    'Africa/Bangui',
    'Africa/Banjul',
    'Africa/Bissau',
    'Africa/Blantyre',
    'Africa/Brazzaville',
    'Africa/Bujumbura',
    'Africa/Cairo',
    'Africa/Casablanca',
    'Africa/Ceuta',
    'Africa/Conakry',
    'Africa/Dakar',
    'Africa/Dar_es_Salaam',
    'Africa/Djibouti',
    'Africa/Douala',
    'Africa/El_Aaiun',
    'Africa/Freetown',
    'Africa/Gaborone',
    'Africa/Harare',
    'Africa/Johannesburg',
    'Africa/Juba',
    'Africa/Kampala',
    'Africa/Khartoum',
    'Africa/Kigali',
    'Africa/Kinshasa',
    'Africa/Lagos',
    'Africa/Libreville',
    'Africa/Lome',
    'Africa/Luanda',
    'Africa/Lubumbashi',
    'Africa/Lusaka',
    'Africa/Malabo',
    'Africa/Maputo',
    'Africa/Maseru',
    'Africa/Mbabane',
    'Africa/Mogadishu',
    'Africa/Monrovia',
    'Africa/Nairobi',
    'Africa/Ndjamena',
    'Africa/Niamey',
    'Africa/Nouakchott',
    'Africa/Ouagadougou',
    'Africa/Porto-Novo',
    'Africa/Sao_Tome',
    'Africa/Tripoli',
    'Africa/Tunis',
    'Africa/Windhoek',
    'America/Adak',
    'America/Anchorage',
    'America/Anguilla',
    'America/Antigua',
    'America/Araguaina',
    'America/Argentina/Buenos_Aires',
    'America/Argentina/Catamarca',
    'America/Argentina/Cordoba',
    'America/Argentina/Jujuy',
    'America/Argentina/La_Rioja',
    'America/Argentina/Mendoza',
    'America/Argentina/Rio_Gallegos',
    'America/Argentina/Salta',
    'America/Argentina/San_Juan',
    'America/Argentina/San_Luis',
    'America/Argentina/Tucuman',
    'America/Argentina/Ushuaia',
    'America/Aruba',
    'America/Asuncion',
    'America/Atikokan',
    'America/Bahia',
    'America/Bahia_Banderas',
    'America/Barbados',
    'America/Belem',
    'America/Belize',
    'America/Blanc-Sablon',
    'America/Boa_Vista',
    'America/Bogota',
    'America/Boise',
    'America/Cambridge_Bay',
    'America/Campo_Grande',
    'America/Cancun',
    'America/Caracas',
    'America/Cayenne',
    'America/Cayman',
    'America/Chicago',
    'America/Chihuahua',
    'America/Costa_Rica',
    'America/Creston',
    'America/Cuiaba',
    'America/Curacao',
    'America/Danmarkshavn',
    'America/Dawson',
    'America/Dawson_Creek',
    'America/Denver',
    'America/Detroit',
    'America/Dominica',
    'America/Edmonton',
    'America/Eirunepe',
    'America/El_Salvador',
    'America/Fort_Nelson',
    'America/Fortaleza',
    'America/Glace_Bay',
    'America/Godthab',
    'America/Goose_Bay',
    'America/Grand_Turk',
    'America/Grenada',
    'America/Guadeloupe',
    'America/Guatemala',
    'America/Guayaquil',
    'America/Guyana',
    'America/Halifax',
    'America/Havana',
    'America/Hermosillo',
    'America/Indiana/Indianapolis',
    'America/Indiana/Knox',
    'America/Indiana/Marengo',
    'America/Indiana/Petersburg',
    'America/Indiana/Tell_City',
    'America/Indiana/Vevay',
    'America/Indiana/Vincennes',
    'America/Indiana/Winamac',
    'America/Inuvik',
    'America/Iqaluit',
    'America/Jamaica',
    'America/Juneau',
    'America/Kentucky/Louisville',
    'America/Kentucky/Monticello',
    'America/Kralendijk',
    'America/La_Paz',
    'America/Lima',
    'America/Los_Angeles',
    'America/Lower_Princes',
    'America/Maceio',
    'America/Managua',
    'America/Manaus',
    'America/Marigot',
    'America/Martinique',
    'America/Matamoros',
    'America/Mazatlan',
    'America/Menominee',
    'America/Merida',
    'America/Metlakatla',
    'America/Mexico_City',
    'America/Miquelon',
    'America/Moncton',
    'America/Monterrey',
    'America/Montevideo',
    'America/Montserrat',
    'America/Nassau',
    'America/New_York',
    'America/Nipigon',
    'America/Nome',
    'America/Noronha',
    'America/North_Dakota/Beulah',
    'America/North_Dakota/Center',
    'America/North_Dakota/New_Salem',
    'America/Ojinaga',
    'America/Panama',
    'America/Pangnirtung',
    'America/Paramaribo',
    'America/Phoenix',
    'America/Port-au-Prince',
    'America/Port_of_Spain',
    'America/Porto_Velho',
    'America/Puerto_Rico',
    'America/Rainy_River',
    'America/Rankin_Inlet',
    'America/Recife',
    'America/Regina',
    'America/Resolute',
    'America/Rio_Branco',
    'America/Santa_Isabel',
    'America/Santarem',
    'America/Santiago',
    'America/Santo_Domingo',
    'America/Sao_Paulo',
    'America/Scoresbysund',
    'America/Sitka',
    'America/St_Barthelemy',
    'America/St_Johns',
    'America/St_Kitts',
    'America/St_Lucia',
    'America/St_Thomas',
    'America/St_Vincent',
    'America/Swift_Current',
    'America/Tegucigalpa',
    'America/Thule',
    'America/Thunder_Bay',
    'America/Tijuana',
    'America/Toronto',
    'America/Tortola',
    'America/Vancouver',
    'America/Whitehorse',
    'America/Winnipeg',
    'America/Yakutat',
    'America/Yellowknife',
    'Antarctica/Casey',
    'Antarctica/Davis',
    'Antarctica/DumontDUrville',
    'Antarctica/Macquarie',
    'Antarctica/Mawson',
    'Antarctica/McMurdo',
    'Antarctica/Palmer',
    'Antarctica/Rothera',
    'Antarctica/Syowa',
    'Antarctica/Troll',
    'Antarctica/Vostok',
    'Arctic/Longyearbyen',
    'Asia/Aden',
    'Asia/Almaty',
    'Asia/Amman',
    'Asia/Anadyr',
    'Asia/Aqtau',
    'Asia/Aqtobe',
    'Asia/Ashgabat',
    'Asia/Baghdad',
    'Asia/Bahrain',
    'Asia/Baku',
    'Asia/Bangkok',
    'Asia/Beirut',
    'Asia/Bishkek',
    'Asia/Brunei',
    'Asia/Chita',
    'Asia/Choibalsan',
    'Asia/Colombo',
    'Asia/Damascus',
    'Asia/Dhaka',
    'Asia/Dili',
    'Asia/Dubai',
    'Asia/Dushanbe',
    'Asia/Gaza',
    'Asia/Hebron',
    'Asia/Ho_Chi_Minh',
    'Asia/Hong_Kong',
    'Asia/Hovd',
    'Asia/Irkutsk',
    'Asia/Jakarta',
    'Asia/Jayapura',
    'Asia/Jerusalem',
    'Asia/Kabul',
    'Asia/Kamchatka',
    'Asia/Karachi',
    'Asia/Kathmandu',
    'Asia/Khandyga',
    'Asia/Kolkata',
    'Asia/Krasnoyarsk',
    'Asia/Kuala_Lumpur',
    'Asia/Kuching',
    'Asia/Kuwait',
    'Asia/Macau',
    'Asia/Magadan',
    'Asia/Makassar',
    'Asia/Manila',
    'Asia/Muscat',
    'Asia/Nicosia',
    'Asia/Novokuznetsk',
    'Asia/Novosibirsk',
    'Asia/Omsk',
    'Asia/Oral',
    'Asia/Phnom_Penh',
    'Asia/Pontianak',
    'Asia/Pyongyang',
    'Asia/Qatar',
    'Asia/Qyzylorda',
    'Asia/Rangoon',
    'Asia/Riyadh',
    'Asia/Sakhalin',
    'Asia/Samarkand',
    'Asia/Seoul',
    'Asia/Shanghai',
    'Asia/Singapore',
    'Asia/Srednekolymsk',
    'Asia/Taipei',
    'Asia/Tashkent',
    'Asia/Tbilisi',
    'Asia/Tehran',
    'Asia/Thimphu',
    'Asia/Tokyo',
    'Asia/Ulaanbaatar',
    'Asia/Urumqi',
    'Asia/Ust-Nera',
    'Asia/Vientiane',
    'Asia/Vladivostok',
    'Asia/Yakutsk',
    'Asia/Yekaterinburg',
    'Asia/Yerevan',
    'Atlantic/Azores',
    'Atlantic/Bermuda',
    'Atlantic/Canary',
    'Atlantic/Cape_Verde',
    'Atlantic/Faroe',
    'Atlantic/Madeira',
    'Atlantic/Reykjavik',
    'Atlantic/South_Georgia',
    'Atlantic/St_Helena',
    'Atlantic/Stanley',
    'Australia/Adelaide',
    'Australia/Brisbane',
    'Australia/Broken_Hill',
    'Australia/Currie',
    'Australia/Darwin',
    'Australia/Eucla',
    'Australia/Hobart',
    'Australia/Lindeman',
    'Australia/Lord_Howe',
    'Australia/Melbourne',
    'Australia/Perth',
    'Australia/Sydney',
    'Europe/Amsterdam',
    'Europe/Andorra',
    'Europe/Athens',
    'Europe/Belgrade',
    'Europe/Berlin',
    'Europe/Bratislava',
    'Europe/Brussels',
    'Europe/Bucharest',
    'Europe/Budapest',
    'Europe/Busingen',
    'Europe/Chisinau',
    'Europe/Copenhagen',
    'Europe/Dublin',
    'Europe/Gibraltar',
    'Europe/Guernsey',
    'Europe/Helsinki',
    'Europe/Isle_of_Man',
    'Europe/Istanbul',
    'Europe/Jersey',
    'Europe/Kaliningrad',
    'Europe/Kiev',
    'Europe/Lisbon',
    'Europe/Ljubljana',
    'Europe/London',
    'Europe/Luxembourg',
    'Europe/Madrid',
    'Europe/Malta',
    'Europe/Mariehamn',
    'Europe/Minsk',
    'Europe/Monaco',
    'Europe/Moscow',
    'Europe/Oslo',
    'Europe/Paris',
    'Europe/Podgorica',
    'Europe/Prague',
    'Europe/Riga',
    'Europe/Rome',
    'Europe/Samara',
    'Europe/San_Marino',
    'Europe/Sarajevo',
    'Europe/Simferopol',
    'Europe/Skopje',
    'Europe/Sofia',
    'Europe/Stockholm',
    'Europe/Tallinn',
    'Europe/Tirane',
    'Europe/Uzhgorod',
    'Europe/Vaduz',
    'Europe/Vatican',
    'Europe/Vienna',
    'Europe/Vilnius',
    'Europe/Volgograd',
    'Europe/Warsaw',
    'Europe/Zagreb',
    'Europe/Zaporozhye',
    'Europe/Zurich',
    'Indian/Antananarivo',
    'Indian/Chagos',
    'Indian/Christmas',
    'Indian/Cocos',
    'Indian/Comoro',
    'Indian/Kerguelen',
    'Indian/Mahe',
    'Indian/Maldives',
    'Indian/Mauritius',
    'Indian/Mayotte',
    'Indian/Reunion',
    'Pacific/Apia',
    'Pacific/Auckland',
    'Pacific/Bougainville',
    'Pacific/Chatham',
    'Pacific/Chuuk',
    'Pacific/Easter',
    'Pacific/Efate',
    'Pacific/Enderbury',
    'Pacific/Fakaofo',
    'Pacific/Fiji',
    'Pacific/Funafuti',
    'Pacific/Galapagos',
    'Pacific/Gambier',
    'Pacific/Guadalcanal',
    'Pacific/Guam',
    'Pacific/Honolulu',
    'Pacific/Johnston',
    'Pacific/Kiritimati',
    'Pacific/Kosrae',
    'Pacific/Kwajalein',
    'Pacific/Majuro',
    'Pacific/Marquesas',
    'Pacific/Midway',
    'Pacific/Nauru',
    'Pacific/Niue',
    'Pacific/Norfolk',
    'Pacific/Noumea',
    'Pacific/Pago_Pago',
    'Pacific/Palau',
    'Pacific/Pitcairn',
    'Pacific/Pohnpei',
    'Pacific/Port_Moresby',
    'Pacific/Rarotonga',
    'Pacific/Saipan',
    'Pacific/Tahiti',
    'Pacific/Tarawa',
    'Pacific/Tongatapu',
    'Pacific/Wake',
    'Pacific/Wallis',
    'UTC'
);

?>