<?php

namespace App\Service;

use App\Entity\BorrowedBook;

/**
 * Class MailService.
 *
 * @package App\Service
 */
class MailService
{
    const SENDER = 'admin-biblio@ekino.com';

    private $mailer;

    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * Confirm borrower for home and bench reservation.
     */
    public function sendMailConfirmBorrower(BorrowedBook $borrowedBook)
    {
        $message = (new \Swift_Message("Confirmation de réservation de " . $borrowedBook->getBook()->getTitle()))
            ->setFrom(self::SENDER)
            ->setTo($borrowedBook->getUser()->getEmail())
            ->setBody(
                $this->twig->render(
                    'mail/borrow_confirm.html.twig',
                    ['borrowedBook' => $borrowedBook]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * Inform owner for bench reservation.
     */
    public function sendMailInformOwner(BorrowedBook $borrowedBook)
    {
        $message = (new \Swift_Message("Information de réservation de " . $borrowedBook->getBook()->getTitle()))
            ->setFrom(self::SENDER)
            ->setTo($borrowedBook->getBook()->getOwner()->getEmail())
            ->setBody(
                $this->twig->render(
                    'mail/borrow_inform.html.twig',
                    ['borrowedBook' => $borrowedBook]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * Ask owner for home reservation.
     */
    public function sendMailAskOwner(BorrowedBook $borrowedBook)
    {
        $message = (new \Swift_Message("Demande de réservation de " . $borrowedBook->getBook()->getTitle()))
            ->setFrom(self::SENDER)
            ->setTo($borrowedBook->getBook()->getOwner()->getEmail())
            ->setBody(
                $this->twig->render(
                    'mail/borrow_ask.html.twig',
                    ['borrowedBook' => $borrowedBook]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * Confirm owner for home reservation.
     */
    public function sendMailConfirmOwner(BorrowedBook $borrowedBook)
    {
        $message = (new \Swift_Message("Confirmation de réservation de " . $borrowedBook->getBook()->getTitle()))
            ->setFrom(self::SENDER)
            ->setTo($borrowedBook->getBook()->getOwner()->getEmail())
            ->setBody(
                $this->twig->render(
                    'mail/borrow_confirm_owner.html.twig',
                    ['borrowedBook' => $borrowedBook]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * Decline home reservation for borrower.
     */
    public function sendMailDeclineBorrower(BorrowedBook $borrowedBook)
    {
        $message = (new \Swift_Message("Refus de l'emprunt de " . $borrowedBook->getBook()->getTitle()))
            ->setFrom(self::SENDER)
            ->setTo($borrowedBook->getUser()->getEmail())
            ->setBody(
                $this->twig->render(
                    'mail/borrow_decline.html.twig',
                    ['borrowedBook' => $borrowedBook]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * Inform the owner that the book was returned.
     */
    public function sendMailReturnOwner(BorrowedBook $borrowedBook)
    {
        $message = (new \Swift_Message("Retour de " . $borrowedBook->getBook()->getTitle()))
            ->setFrom(self::SENDER)
            ->setTo($borrowedBook->getBook()->getOwner()->getEmail())
            ->setBody(
                $this->twig->render(
                    'mail/borrow_return.html.twig',
                    ['borrowedBook' => $borrowedBook]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
