<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\WelcomeEmailRequest;
use App\Mail\Welcome;
use Illuminate\Mail\Mailer;

/**
 * Class EmailController.
 */
class EmailController extends Controller
{
    /**
     * @var Welcome
     */
    private $welcomeEmail;
    /**
     * @var Mailer
     */
    private $Mailer;

    /**
     * EmailController constructor.
     *
     * @param Welcome $welcomeEmail
     * @param Mailer  $Mailer
     */
    public function __construct(
        Welcome $welcomeEmail,
        Mailer $Mailer)
    {
        $this->setWelcomeEmail($welcomeEmail);
        $this->setMailer($Mailer);
    }

    /**
     * @param WelcomeEmailRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function welcomeEmail(WelcomeEmailRequest $request)
    {
        // need to create the Welcome email first
        $welcomeEmail = $this->getWelcomeEmail();

        // send/queue the email.
        $this->getMailer()
            ->to($request->get('email'))
            ->queue($welcomeEmail);

        return redirect()->back();
    }

    /**
     * @return Welcome
     */
    public function getWelcomeEmail(): Welcome
    {
        return $this->welcomeEmail;
    }

    /**
     * @param Welcome $welcomeEmail
     *
     * @return EmailController
     */
    public function setWelcomeEmail(Welcome $welcomeEmail): EmailController
    {
        $this->welcomeEmail = $welcomeEmail;

        return $this;
    }

    /**
     * @return Mailer
     */
    public function getMailer(): Mailer
    {
        return $this->Mailer;
    }

    /**
     * @param Mailer $Mail
     *
     * @return EmailController
     */
    public function setMailer(Mailer $Mail): EmailController
    {
        $this->Mailer = $Mail;

        return $this;
    }

    /**
     * @return Welcome
     */
    protected function getNewWelcomeEmail(): Welcome
    {
        $welcomeEmail = $this->getWelcomeEmail();
        $welcomeEmail = new $welcomeEmail();

        return $welcomeEmail;
    }
}
