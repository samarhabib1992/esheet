<?php
namespace App\Services\Admin;

use Exception;
use App\Mail\TemplateMail;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class CustomEmailService
{
    public function sendTestEmail($recipientEmail, $mailData)
    {
        try {
            // Fetch the email credentials and other settings from the database
            $credentials = Setting::select(
                'smtp_mail_host', 
                'smtp_mail_port', 
                'smtp_mail_username', 
                'smtp_mail_password', 
                'smtp_mail_from_address', 
                'smtp_mail_from_name' 
            )->first();

            // Set mail configuration dynamically
            Config::set('mail.mailers.smtp.host', $credentials->smtp_mail_host);
            Config::set('mail.mailers.smtp.port', $credentials->smtp_mail_port);
            Config::set('mail.mailers.smtp.username', $credentials->smtp_mail_username);
            Config::set('mail.mailers.smtp.password', $credentials->smtp_mail_password);
            Config::set('mail.from.address', $credentials->smtp_mail_from_address);
            Config::set('mail.from.name', $credentials->smtp_mail_from_name);

            // Create the email data array with dynamic values from the settings
            $emailData = [
                'subject' => $mailData['subject'],
                'content' => $mailData['content'],  // email body content
                'from_email' => $credentials->smtp_mail_from_address,
                'from_name' => $credentials->smtp_mail_from_name,
                'cc' => null,
                'bcc' => null, 
                'reply_to' => 'no-reply@esheet.com', //
                'attachments' => $mailData['attachments'] ?? [], // Optional attachments
            ];

            // Send email using the TemplateMail Mailable
            Mail::to($recipientEmail)->send(new TemplateMail($emailData));

            return ['status' => 'success', 'message' => 'Test email sent successfully!'];
        } catch (Exception $e) {
            // Handle any errors during sending
            return ['status' => 'error', 'message' => 'Failed to send test email: ' . $e->getMessage()];
        }
    }
}
