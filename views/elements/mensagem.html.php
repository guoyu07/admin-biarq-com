<?php

/*
 * 
 * 
 */
$msg = $this->session->message();
if ($msg) {
    //debug

    echo '<div id="message-' . $msg['status'] . '">
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="' . $msg['status'] . '-left">' . $msg['msg'] . '</a></td>
            <td class="' . $msg['status'] . '-right"><a class="close-' . $msg['status'] . '"><img src="http://admin.biarq.com/img/table/icon_close_'.$msg['status'].'.gif"   alt="" /></a></td>
        </tr>
    </table>
</div>';
}
?>
