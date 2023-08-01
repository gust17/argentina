<?php
function alerts($message, $type = 'success', $windowAlert = false){

    return '<div class="alert alert-'.$type.' '.(($windowAlert) ? 'windowAlert' : '').' text-center">'.$message.'</div>';
}

function badge($message, $type = 'success'){

    return '<span class="badge badge-'.$type.' windowAlert text-center">'.$message.'</span>';
}