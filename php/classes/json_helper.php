<?php

class json_helper {
    public static function tickets2json($tickets) {
        $jsonTable = [];
        foreach($tickets as $ticket) {
            $bg_color = '#449C42';
            if(empty($ticket->get_close_date())) {
                if(date('Y-m-d') > $ticket->get_due_date())
                    $bg_color = '#DF2828';
                else {
                    switch ($ticket->get_priority()) {
                        case 'low':
                            $bg_color = '#636A76';
                            break;
                        case 'medium':
                            $bg_color = '#4E7EC7';
                            break;
                        case 'high':
                            $bg_color = '#D7A700';
                            break;
                    }
                }
            }

            $jsonTable[] = ['id' => ''.$ticket->get_id(), 'title' => $ticket->get_title(),
                'start' => $ticket->get_start_date(), 'end' => $ticket->get_due_date(),
                'backgroundColor' => $bg_color, 'url' => 'ticket.php?id='.$ticket->get_id(), 'allDay' => true];
        }
        return json_encode($jsonTable);
    }
}