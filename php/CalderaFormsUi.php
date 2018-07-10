<?php
namespace calderawp\CalderaForms\Admin;

function CalderaFormsUi(){
    static $calderaFormsUi;
    if( ! is_object( $calderaFormsUi ) ){
        $calderaFormsUi = new Container();
    }

    return $calderaFormsUi;

}