<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;

class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $urlToResetForm = url( "/reset-password/?token=".$this->token); //"https://vueapp.test/vue-app/reset-password-form/?token=". $this->token;
        return (new MailMessage)

            ->subject(Lang::getFromJson('การขอตั้งรหัสผ่านใหม่ สำหรับระบบถอนคืนเงินรายได้แผ่นดิน'))
            ->greeting(Lang::getFromJson('ข้อความจากระบบ'))

            ->line(Lang::getFromJson('คุณได้ทำรายการขอตั้งรหัสผ่านใหม่ กดปุ่ม "ตั้งรหัสผ่านใหม่" เพื่อทำรายการ'))
            ->action(Lang::getFromJson('ตั้งรหัสผ่านใหม่'), $urlToResetForm)
            ->salutation(Lang::getFromJson('หากไม่สามารถกดปุ่ม "ตั้งรหัสผ่านใหม่" กรุณาคัดลอกข้อความด้านล่างนี้ไปยังเว็บเบราว์เซอร์ของคุณ :path', ['path' => url( "/reset-password/?token=".$this->token)]))
            ->line(Lang::getFromJson('การทำรายการนี้จะหมดอายุใน :count นาที.', ['count' => config('auth.passwords.users.expire')]));
            // ->line(Lang::getFromJson('If you did not request a password reset, no further action is required. Token: ==>'. $this->token));

    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
