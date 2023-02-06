<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exception Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used in
    | Exception Handler.
    |
    */

    'validation'   => 'Validation Error',
    'failure' => 'Failure',
    'unauthorized'   => 'You do not have the required authorization.',
    'invalid_token'   => 'This password reset token is invalid!',
    'invalid_credentials' => 'Invalid Credentials',
    'expired_token'   => 'This password reset token link is expired!',
    'user_not_found'   => 'We can\'t find a user with that e-mail address!',
    'auth'   => 'Invalid/Expired token',
    'invalid_input_fields'   => 'Invalid fields!',
    'account_disabled'   => 'Your account is disabled!',
    'user_email_not_verified' => 'Email not verified',
    'admin_cant_delete' => 'Super Admin can\'t be deleted',
    'old_password_mismatch' => 'Old password is incorrect!',
    'cannot_delete_record' => 'You cannot delete this record. User exists against this HearAboutUsPlatform',
    'observer_listen_not_found' => 'Missing listen variable against observer!',
    'kyc_validation_document_exists' => 'KYC validation document already exists',
    'kyc_validation_exists' => 'KYC validation already exists',
    'kyc_validation_document_update_fail' => 'Document can\'t be updated. KYC validation already approved!',
    'game_not_live' => 'Game is not live.',
    'unauthorized_game_player' => 'Unauthorized to play this game.',
    'player_already_playing_game' => 'Already playing another game!',
    'player_already_playing_this_game' => 'Already playing this game!',
    'inserting_score_before_playing_game' => 'To insert new score you should play game first!',
    'invalid_payment_service_type' => 'Invalid payment service type!',
    'internal_deposit_error' => 'Internal deposit error!',
    'insufficient_wallet_balance_for_withdrawal' => 'Insufficient wallet balance!',
    'amount_limit_below_or_exceed_error' => 'Amount should be between :min and :max',
    'insufficient_balance_to_play_game' => 'Not enough balance in wallet to play the game',
    'internal_payout_error' => 'Internal payout error!',
    'game_player_delete_error' => 'Player is playing the game. You cannot delete the player',
    'payout_update_error' => 'Payout is already approved',
    'payout_request_error' => 'Game is not finished. You cannot request for payout',
    'user_not_exists' => 'User does not exists',
    'invalid_user_auth_token' => 'Invalid User Auth Token!',
    'amount_limit_exceed_without_kyc_process' => 'Complete the kyc process to credit more than :maxWithdrawLimitWithoutKyc :currency',
    'payout_request_sent' => 'Payout request is already sent',
    'payout_request_without_game' => 'Your earnings for this game is zero',
    'live_game_delete_error' => 'Live game cannot be deleted',
    'approved_kyc_delete_error' => 'Approved kyc validation cannot be deleted',
    'stop_game_error' => "Internal game error",
    'live_game_not_exists' => 'Live game does not exists',
    'internal_withdrawal_error' => 'Internal withdrawal error',
    'internal_game_play_error' => 'Internal game play error',
    'delete_ticket_error' => 'Support request is in progress. You cannot delete the Support request',
    'ticket_status_error' => 'You cannot change the status of closed Support request',
    'user_already_disabled' => 'User is already disabled',
    'inserting_score_with_same_attempt_number' => 'Score with the attempt number already exists!',
    'inserting_attemp_score_invalid_order' => 'Invalid game score attempt number! It should be :attemptNo',
    'attempt_number_greater_than_limit_error' => 'Attempt number should be less than or equal to :totalAttempts',
    'payout_request_already_approved' => 'Payout is already approved!',
    'invalid_api_key' => 'API key is invalid!',
    'unable_to_request_api' => 'Unable to request API endpoint',
    'invalid_config' => 'Invalid or empty config',
    'invalid_base_url' => 'Invalid or empty base url',
    'invalid_payment_details' => 'Invalid payment details'
];
