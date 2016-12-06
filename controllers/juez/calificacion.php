<?php
class Calificacion extends CLweb
{

//--------------------------------------------------------------------------------
    public function assignTypeMessage($type, $msg)
    {
        return '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
    }

}
