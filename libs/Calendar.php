<?php
namespace Libs;
require_once 'Curl.php';

/**
 * @see https://developers.google.com/google-apps/calendar/v3/reference/events/list#try-it
 */
class Calendar {
    
    const CALENDAR_ID = 'dkflug%40gmail.com';
    const API_KEY = 'AIzaSyCvZUhnHYbcjJ41X62vJ9ulB3iCVjOVkJ4';
    const GOOGLE_CALENDAR_URL = 'https://www.googleapis.com/calendar/v3/calendars';
    
    private $curl;
    private $calendarUrl;
    
    function __construct() {
        $this->calendarUrl = self::GOOGLE_CALENDAR_URL.'/'.self::CALENDAR_ID.'/events';
        $this->curl = new \Libs\Curl();
    }
    
    public function getFutureEvents($limit) {
        return $this->getCalendar(gmdate("Y-m-d\TH:i:s\Z"), $limit);
    }
    
    public function getCalendar($datetime, $limit) {        
        $queryParam = array(
            'key' => self::API_KEY,
            'singleEvents' => 'true',
            'orderBy' => 'startTime',
            'timeMin' => $datetime
        );
        
        if (is_numeric($limit)) {
            $queryParam['maxResults'] = $limit;
        }

        $status = $this->curl->get($this->calendarUrl, $queryParam);
        if ($status) {
            return $this->curl->responseBody;
        }
        return '{}';
    }
    
}
