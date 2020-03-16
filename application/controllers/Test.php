<?php

class Test extends MY_Controller {

    protected $title = 'Test';

    function __construct() {
        parent::__construct();
    }

    function star($n) {
        $starChar = '*';
        $spaceChar = '-';
        $pos = 0;
        for ($row = 0; $row < $n; $row++) {
            for ($col = 0; $col < $n; $col++) {
                if (true) {
                    echo $starChar;
                } else {
                    echo $spaceChar;
                }
            }
            echo '<br/>';
        }
    }

    function collapse() {
        $this->render('test/collapse');
    }

}
