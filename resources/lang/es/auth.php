<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        "user"  =>  [
        "title_edit"    =>  "Editar Datos"
    ],
    "login" => [
        "title_login" => "Acceso a ".env("APP_NAME", "Gestor de Documentos"),
        "remember_me" => "Recuerdame",
        "recover_password" => "Recuperar Contraseña",
        "signin" => "Acceder",
        "error" => [
            "not_found" => "El usuario incorrecto",
            "max_attempts" => "Ha superado el límite de Intentos",
            "max_blocked_minutes" => "Minutos de Bloqueo de Cuenta"
        ]
    ],
    "logout" => [
        "title_logout" => "Salir"
    ],
    "recover_password" => [
        "title_recover_password" => "Recuperar Contraseña",
        "send_link" => "Enviar enlace de restablecimiento de contraseña",
        "error" => [
            "not_found" => "No Existe el Usuario"
        ],
        "success" => [
            "message" => "Se envío el enlace de Recuperación a su correo"
        ]
    ],
    "reset_password" => [
        "title_reset_password" => "Reseteo de Contraseña",
        "title_button" => "Actualizar Contraseña",
        "error" => [
            "email" => "Usuario es Requerido",
            "user_not_found" => "Usuario No Existe",
            "password_not_equals" => "Las contraseñas son diferentes",
            "password_min_size" => "La contraseña debe tener por lo menos 8 caracteres",
            "token_expired" => "La solicitud expiro, favor generar una nueva solicitud de contraseña",
            "success" => "Contraseña Actualizada"
        ]
    ],  
    "captcha" => [
        "error_validation" => "Error en Validación de reCaptcha v2" 
    ],
    "form" => [
        "user_name"         => "Usuario",
        "password"          => "Contraseña",
        "new_password"      => "Nueva Contraseña",
        "confirm_password"  => "Confirmar Contraseña"
    ]

];
