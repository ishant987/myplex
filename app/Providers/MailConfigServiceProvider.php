<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('MAIL_HOST') && env('MAIL_USERNAME')) {
            $this->applySmtpConfig([
                'driver' => env('MAIL_MAILER', 'smtp'),
                'host' => env('MAIL_HOST'),
                'port' => env('MAIL_PORT', 587),
                'from' => [
                    'address' => env('MAIL_FROM_ADDRESS'),
                    'name' => env('MAIL_FROM_NAME', config('app.name')),
                ],
                'encryption' => $this->normalizeEncryption(env('MAIL_PORT'), env('MAIL_ENCRYPTION')),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            ]);

            return;
        }

       /* if (\Schema::hasTable('mails')) {
            $mail = DB::table('mails')->first();
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'driver'     => $mail->driver,
                    'host'       => $mail->host,
                    'port'       => $mail->port,
                    'from'       => array('address' => $mail->from_address, 'name' => $mail->from_name),
                    'encryption' => $mail->encryption,
                    'username'   => $mail->username,
                    'password'   => $mail->password,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            }
        }*/

        if (\Schema::hasTable('options')) 
        {
            $optionKeyArr = ['smtp_secure', 'smtp_hostname', 'smtp_port', 'smtp_username', 'smtp_password','from_email', 'title'];
            $mail = DB::table('options')->select('option_key','option_value')->whereIn('option_key', $optionKeyArr)->pluck('option_value','option_key')->toArray();

            if ($mail) //checking if table is not empty
            {
                $configArr = $fromArr = [];

                foreach ($mail as $key => $value) 
                {
                    if($key=='smtp_secure'){
                        $configArr['encryption'] = $value;                
                    }
                    if($key=='smtp_hostname'){
                        $configArr['host'] = $value;                
                    }
                    if($key=='smtp_port'){
                        $configArr['port'] = $value;                
                    }
                    if($key=='smtp_username'){
                        $configArr['username'] = $value;                
                    }
                    if($key=='smtp_password'){
                        $configArr['password'] = $value;                
                    }
                    if($key=='from_email'){
                        $fromArr['address'] = $value;                
                    }
                    if($key=='title'){
                        $fromArr['name'] = $value;                
                    }
                }
                $configArr['driver']    = 'smtp';
                /*$fromArr['name']        = 'Proc Shots';*/
                $configArr['from']      = $fromArr;
                $configArr['sendmail']  = '/usr/sbin/sendmail -bs';
                $configArr['pretend']   = false;
                if($configArr['encryption'] === 'ssl'){
                    $configArr['ssl']   =  array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    );                    
                }
                $configArr['encryption'] = $this->normalizeEncryption($configArr['port'] ?? null, $configArr['encryption'] ?? null);
                $this->applySmtpConfig($configArr);
            }
        }
    }

    protected function normalizeEncryption($port, $encryption): ?string
    {
        if ((int) $port === 465 && strtolower((string) $encryption) === 'tls') {
            return 'ssl';
        }

        return $encryption ?: null;
    }

    protected function applySmtpConfig(array $config): void
    {
        $driver = $config['driver'] ?? 'smtp';

        Config::set('mail.default', $driver);
        Config::set("mail.mailers.{$driver}.transport", $driver);
        Config::set("mail.mailers.{$driver}.host", $config['host'] ?? null);
        Config::set("mail.mailers.{$driver}.port", $config['port'] ?? null);
        Config::set("mail.mailers.{$driver}.encryption", $config['encryption'] ?? null);
        Config::set("mail.mailers.{$driver}.username", $config['username'] ?? null);
        Config::set("mail.mailers.{$driver}.password", $config['password'] ?? null);
        Config::set('mail.from', $config['from'] ?? []);

        // Keep the legacy keys because some older project code still reads them directly.
        Config::set('mail.driver', $driver);
        Config::set('mail.host', $config['host'] ?? null);
        Config::set('mail.port', $config['port'] ?? null);
        Config::set('mail.encryption', $config['encryption'] ?? null);
        Config::set('mail.username', $config['username'] ?? null);
        Config::set('mail.password', $config['password'] ?? null);
        Config::set('mail.sendmail', $config['sendmail'] ?? '/usr/sbin/sendmail -bs');
        Config::set('mail.pretend', $config['pretend'] ?? false);
    }
}
