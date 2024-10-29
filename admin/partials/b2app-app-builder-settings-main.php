<?php

$settings = array(
        array(
            'name' => __( 'Step #1: Registration', 'b2app-app-builder' ),
            'type' => 'title',
            'id'   => $prefix . 'registration_settings'
        ),
        array(
            'id'        => $prefix . 'email',
            'name'      => __( 'Email for B2App', 'b2app-app-builder' ), 
            'type'      => 'email',
            'desc_tip'  => __( 'Enter email for B2App', 'b2app-app-builder')
        ),
        array(
            'id'        => $prefix . 'password',
            'name'      => __( 'Password for B2App', 'b2app-app-builder' ), 
            'type'      => 'password',
            'desc_tip'  => __( 'Enter password for B2App', 'b2app-app-builder')
        ),
        array(
            'id'        => $prefix . 'agree',
            'name'      => __( 'I agree with the privacy policy', 'b2app-app-builder' ),
            'type'      => 'checkbox',
            'default'   => 'no'
        ),   
        array(
            'id'        => '',
            'name'      => __( 'Step #1: Registration', 'b2app-app-builder' ),
            'type'      => 'sectionend',
            'desc'      => '',
            'id'        => $prefix . 'registration_settings'
        ),
    );
?>