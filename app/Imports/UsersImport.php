<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

use Validator;

use DB;

use App\Lib\Core\Useful;
use App\Lib\Core\MailPS;

use App\Models\User;
use App\Models\UserGroupRelModel;
use App\Models\Plans;

use App\Rules\IsValidDob;
use App\Rules\IsValidPicture;

class UsersImport implements ToCollection, WithHeadingRow
{
    private $rows = 0;
    private $updRows = 0;
    private $duplicateEmailArr = array();

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        $commonconstants = Config('commonconstants');
        $auth = Config('auth');

        $genUsrPswdNo = $commonconstants['gen_usr_password_no'];
        $cuBy = $commonconstants['cu_by_val'][1];
        $loginAdminId = auth()->guard('admin')->user()->admin_id;
        $defUsrGrpId = $commonconstants['def_sbsrbd_usr_grp_id'];
        $yVal = $commonconstants['y_n_val'][1];

        $accType = $auth['acc_type']['value']['0'];

        $uoptTypOpt2Val = $commonconstants['uopt_typ_opt2_val'];
        $yesVal = strtolower(__('common.yes_no_txt.y'));
        $null = $commonconstants['null'];
        $now = now();

        $isMailSend = true; //true / false

        $cellRow = $this->headingRow();
        foreach ($rows as $key => $row) {
            ++$cellRow;

            $email = trim($row['email_id']);
            if ($email) {
                DB::beginTransaction();

                $rulesArr = [
                    'first_name' => 'required',
                    'email_id' => 'required|email',
                    'mobile' => 'required|numeric',
                    'pincode' => 'nullable|numeric',
                    'birthday' => [new IsValidDob],
                    'profile_picture' => [new IsValidPicture]
                ];
                $rulesMsgsArr = [
                    'first_name.required' => 'The column(' . $cellRow . '): first name field is required.',
                    'email_id.email' => 'The column(' . $cellRow . '): email field must be valid email',
                    'mobile.numeric' => 'The column(' . $cellRow . '): mobile field must be valid numeric.',
                    'pincode.numeric' => 'The column(' . $cellRow . '): pincode field must be valid numeric.'
                ];

                Validator::make($row->toArray(), $rulesArr, $rulesMsgsArr)->validate();

                $profilePicture = trim($row['profile_picture']);
                $pincode = trim($row['pincode']);

                $input = [
                    'f_name'     => trim($row['first_name']),
                    'l_name'     => trim($row['last_name']),
                    'mobile'     => trim($row['mobile']),
                    'birthday'   => trim($row['birthday']),
                    'p_picture'  => $profilePicture,
                    'pincode'    => $pincode,
                    'address'    => trim($row['address']),
                    'about'    => trim($row['about']),
                    'profile'    => trim($row['profile']),
                    'company'    => trim($row['company'])
                ];

                $user = User::whereEmail($email)->first();
                if ($user) {
                    $input['p_picture'] = $profilePicture != "" ? $profilePicture : $user->p_picture;

                    ++$this->updRows;
                    foreach ($input as $key => $value) {
                        $user->$key = trim($value);
                    }
                    $user->updated_id = $loginAdminId;
                    $user->updated_by = $cuBy;
                    $user->save();

                    DB::commit();

                    $this->duplicateEmailArr[] = $user->email;
                } else {
                    ++$this->rows;

                    $user = new User;

                    $password = Useful::generateStrongPassword($genUsrPswdNo);

                    foreach ($input as $key => $value) {
                        $user->$key = trim($value);
                    }
                    $user->acc_type = $accType;
                    $user->email = $email;
                    $user->password = bcrypt($password);
                    $user->is_approved = $yVal;
                    $user->created_by = $cuBy;
                    $user->created_id = $loginAdminId;
                    $user->updated_at = $null;
                    $user->save();
                    if ($user->u_id) {
                        $userId = $user->u_id;

                        $role = new UserGroupRelModel;
                        $role->u_g_id       = $defUsrGrpId;
                        $role->u_id         = $userId;
                        $role->updated_id   = $loginAdminId;
                        $role->save();

                        $insertUsrOptArr = [];
                        for ($i = 0; $i < 1; $i++) {
                            $insertUsrOptArr[$i]['type'] = $uoptTypOpt2Val;
                            if ($i == 0) {
                                $insertUsrOptArr[$i]['option_key'] = "gen_ntfy";
                            }
                            $insertUsrOptArr[$i]['option_value'] = $yesVal;
                            $insertUsrOptArr[$i]['u_id'] = $userId;
                            $insertUsrOptArr[$i]['created_at'] = $now;
                            $insertUsrOptArr[$i]['updated_at'] = $now;
                        }
                        Plans::captureFreeTrailPlan(["u_id" => $userId, "created_by" => $cuBy]);

                        DB::commit();

                        if (($isMailSend === true) && (!\App::environment(['local']))) {
                            $mailPSObj = new MailPS();
                            $mailCssAtr = $mailPSObj->getEmailHtmlCssAtr();

                            $fullname = $row['first_name'] . " " . $row['last_name'];
                            $mailArr = ["fullname" => rtrim($fullname), "email" => $email, "password" => $password];

                            $subject    = __('auth.su_reg_mail_sbjct');
                            $content    = view('emails.admin.to-user-signup', compact('mailArr', 'mailCssAtr'));
                            $fromName = __('auth.su_reg_mail_f_name');

                            $mailResp = $mailPSObj->sendMail($email, $subject, $content, '', $fromName);
                        }
                    }
                }
            } elseif ($row['first_name'] && $row['mobile']) {
                Validator::make(
                    $row->toArray(),
                    [
                        'email_id' => 'required|email',
                    ],
                    [
                        'email_id.required' => 'The row(' . $cellRow . '): email field is required.',
                        'email_id.email' => 'The row(' . $cellRow . '): email field must be valid email',
                    ]
                )->validate();
            }
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getUpdRowCount(): int
    {
        return $this->updRows;
    }

    public function getDuplicateEmailArr(): array
    {
        return $this->duplicateEmailArr;
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function startRow(): int
    {
        return 4;
    }
}
