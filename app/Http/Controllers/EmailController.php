<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entities\WelcomeEmailLeadsE;
use App\Http\Requests\WelcomeEmailRequest;
use App\Mail\Welcome;
use App\Services\WelcomeEmailLeadsS;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Collection;

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
     * @var WelcomeEmailLeadsS
     */
    private $welcomeEmailLeadsS;

    /**
     * EmailController constructor.
     *
     * @param Welcome            $welcomeEmail
     * @param Mailer             $Mailer
     * @param WelcomeEmailLeadsS $welcomeEmailLeadsS
     */
    public function __construct(
        Welcome $welcomeEmail,
        Mailer $Mailer,
        WelcomeEmailLeadsS $welcomeEmailLeadsS)
    {
        $this->setWelcomeEmail($welcomeEmail);
        $this->setMailer($Mailer);
        $this->setWelcomeEmailLeadsS($welcomeEmailLeadsS);
    }

    /**
     * @param WelcomeEmailRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function welcomeEmail(WelcomeEmailRequest $request)
    {
        return view('/');

        // save the email address to db
//        $this->getWelcomeEmailLeadsS()
//            ->persistEmail($request);
//
//        // build welcome email
//        $welcomeEmail = $this->buildWelcomeEmail();
//
//        // send/queue the email
//        $this->getMailer()
//            ->to($request->get('email'))
//            ->queue($welcomeEmail);
//
//        return redirect()->back();
    }

    /**
     * @return array
     */
    public function getAllWelcomeEmailLeads()
    {
        $collection = $this->getWelcomeEmailLeadsS()
            ->getAllWelcomeEmailLeads();

        return $this->convertToJsonableType($collection);
    }

    /**
     * @return Welcome
     */
    protected function getWelcomeEmail(): Welcome
    {
        return $this->welcomeEmail;
    }

    /**
     * @param Welcome $welcomeEmail
     *
     * @return EmailController
     */
    protected function setWelcomeEmail(Welcome $welcomeEmail): EmailController
    {
        $this->welcomeEmail = $welcomeEmail;

        return $this;
    }

    /**
     * @return Mailer
     */
    protected function getMailer(): Mailer
    {
        return $this->Mailer;
    }

    /**
     * @param Mailer $Mail
     *
     * @return EmailController
     */
    protected function setMailer(Mailer $Mail): EmailController
    {
        $this->Mailer = $Mail;

        return $this;
    }

    /**
     * @return WelcomeEmailLeadsS
     */
    protected function getWelcomeEmailLeadsS(): WelcomeEmailLeadsS
    {
        return $this->welcomeEmailLeadsS;
    }

    /**
     * @param WelcomeEmailLeadsS $welcomeEmailLeadsS
     *
     * @return EmailController
     */
    protected function setWelcomeEmailLeadsS(WelcomeEmailLeadsS $welcomeEmailLeadsS): EmailController
    {
        $this->welcomeEmailLeadsS = $welcomeEmailLeadsS;

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

    /**
     * @param Collection $collection
     *
     * @return array
     */
    protected function convertToJsonableType(Collection $collection): array
    {
        $result = [];

        // convert the collection to an array
        $entities = $collection->all();

        // convert the array a jsonable return type
        /** @var WelcomeEmailLeadsE $entity */
        foreach ($entities as $entity) {
            foreach (get_class_methods($entity) as $method) {
                if ($entity->isValidMethod($method)) {
                    $result[] = $entity->$method();
                }
            }
        }

        return $result;
    }

    /**
     * @return Welcome
     */
    protected function buildWelcomeEmail(): Welcome
    {
        /** @var Welcome $welcomeEmail */
        $welcomeEmail = $this->getWelcomeEmail();
        $welcomeEmail->setFromEmailAddress('noreply@swinglowoptiontrading.com', 'NoReply');

        return $welcomeEmail;
    }
}
