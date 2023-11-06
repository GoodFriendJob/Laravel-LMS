<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateProfileRequest $request)
    {
        $fieldsList = [];
        if(config('registration_fields') != NULL){
            $fields = json_decode(config('registration_fields'));

            foreach ($fields  as $field){
                $fieldsList[] =  ''.$field->name;
            }
        }
        $output = $this->userRepository->update(
            $request->user()->id,
            $request->only('first_name', 'last_name','dob', 'phone', 'gender', 'address', 'city', 'pincode', 'state', 'country', 'avatar_type', 'avatar_location','email'),
            $request->has('avatar_location') ? $request->file('avatar_location') : false
        );
        if($request->user()->hasRole('teacher')){
            $payment_details = [
                'bank_name'         => request()->payment_method == 'bank'?request()->bank_name:'',
                'ifsc_code'         => request()->payment_method == 'bank'?request()->ifsc_code:'',
                'account_number'    => request()->payment_method == 'bank'?request()->account_number:'',
                'account_name'      => request()->payment_method == 'bank'?request()->account_name:'',
                'paypal_email'      => request()->payment_method == 'paypal'?request()->paypal_email:'',
            ];
            $data = [
                'facebook_link'     => request()->facebook_link,
                'twitter_link'      => request()->twitter_link,
                'linkedin_link'     => request()->linkedin_link,
                'payment_method'    => request()->payment_method,
                'payment_details'   => json_encode($payment_details),
                'description'       => request()->description,
            ];
            $request->user()->teacherProfile->update($data);
        }
        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return redirect()->route('frontend.auth.login')->withFlashInfo(__('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('admin.account')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }
}
