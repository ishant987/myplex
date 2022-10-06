<?php

namespace App\Resolvers;
use Exception;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialUserResolver implements SocialUserResolverInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
      $providerUser = null;

      try {
          $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
      } catch (Exception $exception) {}

        if ($providerUser) {

  		      $user = null;

            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }

            return $user;
        }

      return null;
    }
}
