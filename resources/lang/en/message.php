<?php

return [

    /*
    |--------------------------------------------------------------------------
    | response Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'update' => '<div class="alert alert-success">The data was updated!</div>',
    'delete' => '<div class="alert alert-success">The data was deleted!</div>',
    'store' => '<div class="alert alert-success">The data was stored!</div>',
    'sent' => '<div class="alert alert-success">The message was sucessfuly sent. We will reply you as soon as possible</div>',
    'create' => '<div class="alert alert-success">The user data was created!</div>',   
    'alpha_num' => '<div class="alert alert-success">Details Updated Successfully</div>',
    'first_create' => '<div class="alert alert-success">Details Created Successfully. Please login </div>',    
    'error' => [
        'delete' => '<div class="alert alert-danger">An error occurred while deleting the data. :reason</div>',
        'admin_action' => '<div class="alert alert-danger alert-dismissible fade show"> You must be an admin to perform this action <button type="button" onclick="hide()">&times;</button></div>',
        'admin_view' => 'You must be an admin to view this page!',
        'array' => 'The :attribute must have at least :min items.',
    ],


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
