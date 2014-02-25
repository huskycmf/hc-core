<?php
namespace HcCore\Service;

use Zend\Mail\Transport\TransportInterface;
use Zend\Mail\Message as MailMessage;

class MailService
{
    /**
     * @var TransportInterface
     */
    protected $mailTransport;

    public function __construct(TransportInterface $transport)
    {
        $this->mailTransport = $transport;
    }

    /**
     * @param MailMessage $message
     *
     * @throws \RuntimeException
     * @return boolean
     */
    public function send(MailMessage $message)
    {
        $this->mailTransport->send($message);
    }
}
