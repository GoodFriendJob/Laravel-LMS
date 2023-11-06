<?php

return array (
  'required' => 'The :attribute field is required.',
  'attributes' => 
  array (
    'frontend' => 
    array (
      'old_password' => 'Old Password',
      'male' => 'Male',
      'female' => 'Female',
      'other' => 'Other',
      'password' => 'Password',
      'password_confirmation' => 'Password Confirmation',
      'avatar' => 'Avatar Location',
      'first_name' => 'First Name',
      'last_name' => 'Last Name',
      'email' => 'E-mail Address',
      'name' => 'Full Name',
      'phone' => 'Phone',
      'message' => 'Message',
      'new_password' => 'New Password',
      'new_password_confirmation' => 'New Password Confirmation',
      'timezone' => 'Timezone',
      'language' => 'Language',
      'gravatar' => 'Gravatar',
      'upload' => 'Upload',
      'captcha' => 'Captcha required',
      'personal_information' => 'Personal Information',
      'social_information' => 'Social Information',
      'payment_information' => 'Payment Information',
    ),
    'backend' => 
    array (
      'access' => 
      array (
        'roles' => 
        array (
          'name' => 'Name',
          'associated_permissions' => 'Associated Permissions',
          'sort' => 'Sort',
        ),
        'users' => 
        array (
          'password' => 'Password',
          'password_confirmation' => 'Password Confirmation',
          'first_name' => 'First Name',
          'last_name' => 'Last Name',
          'email' => 'E-mail Address',
          'active' => 'Active',
          'confirmed' => 'Confirmed',
          'send_confirmation_email' => 'Send Confirmation E-mail',
          'associated_roles' => 'Associated Roles',
          'name' => 'Name',
          'other_permissions' => 'Other Permissions',
          'timezone' => 'Timezone',
          'language' => 'Language',
        ),
        'permissions' => 
        array (
          'associated_roles' => 'Associated Roles',
          'dependencies' => 'Dependencies',
          'display_name' => 'Display Name',
          'group' => 'Group',
          'group_sort' => 'Group Sort',
          'groups' => 
          array (
            'name' => 'Group Name',
          ),
          'name' => 'Name',
          'first_name' => 'First Name',
          'last_name' => 'Last Name',
          'system' => 'System',
        ),
      ),
      'settings' => 
      array (
        'social_settings' => 
        array (
          'facebook' => 
          array (
            'label' => 'Facebook Login Status',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'redirect' => 'Redirect URL',
          ),
          'google' => 
          array (
            'label' => 'Google Login Status',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'redirect' => 'Redirect URL',
          ),
          'twitter' => 
          array (
            'label' => 'Twitter Login Status',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'redirect' => 'Redirect URL',
          ),
          'linkedin' => 
          array (
            'label' => 'LinkedIn Login Status',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'redirect' => 'Redirect URL',
          ),
          'github' => 
          array (
            'label' => 'Github Login Status',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'redirect' => 'Redirect URL',
          ),
          'bitbucket' => 
          array (
            'label' => 'Bitbucket Login Status',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'redirect' => 'Redirect URL',
          ),
        ),
        'general_settings' => 
        array (
          'app_name' => 'App Name',
          'app_url' => 'App URL',
          'app_locale' => 'App Locale',
          'app_timezone' => 'App Timezone',
          'mail_driver' => 'Mail Driver',
          'mail_host' => 'Mail Host',
          'mail_port' => 'Mail Port',
          'mail_from_name' => 'Mail From Name',
          'lesson_timer' => 'Lesson Timer',
          'mail_from_address' => 'Mail From Address',
          'mail_username' => 'Mail Username',
          'mail_password' => 'Mail Password',
          'enable_registration' => 'Enable Registration',
          'change_email' => 'Change Email',
          'password_history' => 'Password History',
          'password_expires_days' => 'Password Expires Days',
          'requires_approval' => 'Requires Approval',
          'confirm_email' => 'Confirm Email',
          'homepage' => 'Select Homepage',
          'captcha_status' => 'Captcha Status',
          'captcha_site_key' => 'Captcha Key',
          'captcha_site_secret' => 'Captcha Secret',
          'google_analytics' => 'Google Analytics Code',
          'theme_layout' => 'Theme Layout',
          'font_color' => 'Font Color',
          'layout_type' => 'Layout Type',
          'retest_status' => 'Re-Test',
          'show_offers' => 'Show Offers Page',
          'one_signal_push_notification' => 'OneSignal Setup',
          'onesignal_code' => 'Paste OneSignal script code here',
        ),
      ),
    ),
  ),
  'accepted' => 'The :attribute must be accepted.',
  'active_url' => 'The :attribute is not a valid URL.',
  'after' => 'The :attribute must be a date after :date.',
  'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
  'alpha' => 'The :attribute may only contain letters.',
  'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
  'alpha_num' => 'The :attribute may only contain letters and numbers.',
  'array' => 'The :attribute must be an array.',
  'before' => 'The :attribute must be a date before :date.',
  'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
  'between' => 
  array (
    'numeric' => 'The :attribute must be between :min and :max.',
    'file' => 'The :attribute must be between :min and :max kilobytes.',
    'string' => 'The :attribute must be between :min and :max characters.',
    'array' => 'The :attribute must have between :min and :max items.',
  ),
  'boolean' => 'The :attribute field must be true or false.',
  'confirmed' => 'The :attribute confirmation does not match.',
  'date' => 'The :attribute is not a valid date.',
  'date_format' => 'The :attribute does not match the format :format.',
  'different' => 'The :attribute and :other must be different.',
  'digits' => 'The :attribute must be :digits digits.',
  'digits_between' => 'The :attribute must be between :min and :max digits.',
  'dimensions' => 'The :attribute has invalid image dimensions.',
  'distinct' => 'The :attribute field has a duplicate value.',
  'email' => 'The :attribute must be a valid email address.',
  'exists' => 'The selected :attribute is invalid.',
  'file' => 'The :attribute must be a file.',
  'filled' => 'The :attribute field must have a value.',
  'gt' => 
  array (
    'numeric' => 'The :attribute must be greater than :value.',
    'file' => 'The :attribute must be greater than :value kilobytes.',
    'string' => 'The :attribute must be greater than :value characters.',
    'array' => 'The :attribute must have more than :value items.',
  ),
  'gte' => 
  array (
    'numeric' => 'The :attribute must be greater than or equal :value.',
    'file' => 'The :attribute must be greater than or equal :value kilobytes.',
    'string' => 'The :attribute must be greater than or equal :value characters.',
    'array' => 'The :attribute must have :value items or more.',
  ),
  'image' => 'The :attribute must be an image.',
  'in' => 'The selected :attribute is invalid.',
  'in_array' => 'The :attribute field does not exist in :other.',
  'integer' => 'The :attribute must be an integer.',
  'ip' => 'The :attribute must be a valid IP address.',
  'ipv4' => 'The :attribute must be a valid IPv4 address.',
  'ipv6' => 'The :attribute must be a valid IPv6 address.',
  'json' => 'The :attribute must be a valid JSON string.',
  'lt' => 
  array (
    'numeric' => 'The :attribute must be less than :value.',
    'file' => 'The :attribute must be less than :value kilobytes.',
    'string' => 'The :attribute must be less than :value characters.',
    'array' => 'The :attribute must have less than :value items.',
  ),
  'lte' => 
  array (
    'numeric' => 'The :attribute must be less than or equal :value.',
    'file' => 'The :attribute must be less than or equal :value kilobytes.',
    'string' => 'The :attribute must be less than or equal :value characters.',
    'array' => 'The :attribute must not have more than :value items.',
  ),
  'max' => 
  array (
    'numeric' => 'The :attribute may not be greater than :max.',
    'file' => 'The :attribute may not be greater than :max kilobytes.',
    'string' => 'The :attribute may not be greater than :max characters.',
    'array' => 'The :attribute may not have more than :max items.',
  ),
  'mimes' => 'The :attribute must be a file of type: :values.',
  'mimetypes' => 'The :attribute must be a file of type: :values.',
  'min' => 
  array (
    'numeric' => 'The :attribute must be at least :min.',
    'file' => 'The :attribute must be at least :min kilobytes.',
    'string' => 'The :attribute must be at least :min characters.',
    'array' => 'The :attribute must have at least :min items.',
  ),
  'not_in' => 'The selected :attribute is invalid.',
  'not_regex' => 'The :attribute format is invalid.',
  'numeric' => 'The :attribute must be a number.',
  'present' => 'The :attribute field must be present.',
  // 'regex' => 'The :attribute format is invalid.',
  'regex' => 'The :attribute must be at least 6 characters long and contain at least one letter, one digit, and one of the following special characters: !, $, #, or %.',
  'required_if' => 'The :attribute field is required when :other is :value.',
  'required_unless' => 'The :attribute field is required unless :other is in :values.',
  'required_with' => 'The :attribute field is required when :values is present.',
  'required_with_all' => 'The :attribute field is required when :values are present.',
  'required_without' => 'The :attribute field is required when :values is not present.',
  'required_without_all' => 'The :attribute field is required when none of :values are present.',
  'same' => 'The :attribute and :other must match.',
  'size' => 
  array (
    'numeric' => 'The :attribute must be :size.',
    'file' => 'The :attribute must be :size kilobytes.',
    'string' => 'The :attribute must be :size characters.',
    'array' => 'The :attribute must contain :size items.',
  ),
  'string' => 'The :attribute must be a string.',
  'timezone' => 'The :attribute must be a valid zone.',
  'unique' => 'The :attribute has already been taken.',
  'uploaded' => 'The :attribute failed to upload.',
  'url' => 'The :attribute format is invalid.',
  'uuid' => 'The :attribute must be a valid UUID.',
  'custom' => 
  array (
    'attribute-name' => 
    array (
      'rule-name' => 'custom-message',
    ),
  ),
);
