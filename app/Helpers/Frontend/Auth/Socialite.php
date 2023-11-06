<?php

namespace App\Helpers\Frontend\Auth;

/**
 * Class Socialite.
 */
class Socialite
{
    /**
     * Generates social login links based on what is enabled.
     *
     * @return string
     */
    public function getSocialLinks()
    {
        $socialite_enable = [];
        $socialite_links = '';

        if (config('services.facebook.active')) {
            $socialite_enable[] = "<a href='".route('frontend.auth.social.login', 'facebook')."' class='btn btn-sm btn-info text-white  p-1 px-2  m-1 my-3'><i class='fab fa-facebook'></i></a>";
        }


        if (config('services.google.active')) {
            $socialite_enable[] = "<a href='".route('frontend.auth.social.login', 'google')."' class='btn btn-sm btn-info text-white   p-1 px-2  m-1 my-3'><i class='fab fa-google'></i></a>";
        }

        if (config('services.twitter.active')) {
            $socialite_enable[] = "<a href='".route('frontend.auth.social.login', 'twitter')."' class='btn btn-sm btn-info text-white   p-1 px-2  m-1 my-3'><i class='fab fa-twitter'></i></a>";
        }

        if (config('services.linkedin.active')) {
            $socialite_enable[] = "<a href='".route('frontend.auth.social.login', 'linkedin')."' class='btn btn-sm btn-info text-white   p-1 px-2  m-1 my-3'><i class='fab fa-linkedin'></i></a>";
        }


        if (config('services.bitbucket.active')) {
            $socialite_enable[] = "<a href='".route('frontend.auth.social.login', 'bitbucket')."' class='btn btn-sm btn-info text-white  p-1 m-1 my-3'><i class='fab fa-bitbucket'></i></a>";
        }


        if (config('services.github.active')) {
            $socialite_enable[] = "<a href='".route('frontend.auth.social.login', 'github')."' class='btn btn-sm btn-info text-white   p-1 px-2  m-1 my-3'><i class='fab fa-github'></i></a>";
        }


        if ($count = count($socialite_enable)) {
            $socialite_links .= '<div class="alt-text text-center mb-0"><a href="#">SIGN IN WITH</a></div>';
        }

        for ($i = 0; $i < $count; $i++) {
            $socialite_links .= ($socialite_links != '' ? ' ' : '').$socialite_enable[$i];
        }

        return $socialite_links;
    }

    /**
     * List of the accepted third party provider types to login with.
     *
     * @return array
     */
    public function getAcceptedProviders()
    {
        return [
            'bitbucket',
            'facebook',
            'google',
            'github',
            'linkedin',
            'twitter',
        ];
    }
}
