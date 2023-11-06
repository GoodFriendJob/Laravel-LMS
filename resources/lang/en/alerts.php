<?php

return array (
  'backend' => 
  array (
    'general' => 
    array (
      'created' => 'Created successfully.',
      'slug_exist' => 'Record with same slug exist, please update the slug.',
      'error' => 'Something went wrong. Try Again',
      'updated' => 'Updated successfully.',
      'deleted' => 'Deleted successfully.',
      'restored' => 'Restored successfully.',
      'cancelled' => 'Update Cancelled.',
      'unverified' => 'Unverified Update files.',
      'backup_warning' => 'Please fill necessary details for backup',
      'delete_warning' => 'You can not delete course. Students are already enrolled. Unpublish the course instead',
      'delete_warning_bundle' => 'You can not delete Bundle. Students are already enrolled. Unpublish the Bundle instead',
      'teacher_delete_warning' => 'You can not delete teacher. Courses are already added. Change the status instead',
    ),
    'roles' => 
    array (
      'created' => 'The role was successfully created.',
      'updated' => 'The role was successfully updated.',
      'deleted' => 'The role was successfully deleted.',
    ),
    'users' => 
    array (
      'cant_resend_confirmation' => 'The application is currently set to manually approve users.',
      'confirmation_email' => 'A new confirmation e-mail has been sent to the address on file.',
      'confirmed' => 'The user was successfully confirmed.',
      'unconfirmed' => 'The user was successfully un-confirmed',
      'created' => 'The user was successfully created.',
      'updated' => 'The user was successfully updated.',
      'deleted' => 'The user was successfully deleted.',
      'updated_password' => 'The user\'s password was successfully updated.',
      'session_cleared' => 'The user\'s session was successfully cleared.',
      'social_deleted' => 'Social Account Successfully Removed',
      'deleted_permanently' => 'The user was deleted permanently.',
      'restored' => 'The user was successfully restored.',
    ),
    'stripe_plan' => 
    array (
      'stripe_credentials' => 'Stripe credentials not available',
    ),
  ),
  'frontend' => 
  array (
    'contact' => 
    array (
      'sent' => 'Your information was successfully sent. We will respond back to the e-mail provided as soon as we can.',
    ),
    'course' => 
    array (
      'completed' => 'Congratulations! You\'ve successfully completed course. Checkout your certificate in dashboard',
      'slot_booking' => 'Live lesson slot booking successfully',
      'subscription_plan_expired' => 'Your Subscription Plan Expired',
      'subscription_plan_cancelled' => 'Your Subscription Plan Cancelled',
      'sub_course_limit_over' => 'Your Subscription Plan Course Limit Over',
      'sub_bundle_limit_over' => 'Your Subscription Plan Bundle Limit Over',
      'sub_course_success' => 'Course Subscribe Successfully',
      'sub_bundle_success' => 'Bundle Subscribe Successfully',
      'sub_course_not_access' => 'Your Subscription Plan Not Any Course Access',
      'sub_bundle_not_access' => 'Your Subscription Plan Not Any Bundle Access',
    ),
    'duplicate_course' => 'is already course purchased.',
    'duplicate_bundle' => 'is already bundle purchased.',
    'wishlist' => 
    array (
      'exist' => 'This course already in wishlist',
      'added' => 'Course added successfully in wishlist',
    ),
  ),
);
