<?php

namespace App\Command;

use App\Service\BookService;
use App\Service\BorrowedBookService;
use App\Service\MailService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SendReminderMailCommand.
 *
 * @package App\Command
 */
class SendReminderMailCommand extends Command
{
    private $mailService;

    private $bookService;

    private $borrowedBookService;

    protected function configure()
    {
        $this->setName('app:send-reminder-email')
            ->setDescription('Send a reminder email to return the book.')
            ->setHelp('This command is used to send an email to remind the borrower to not forget to return the book')
            ->addArgument('numberDays', InputArgument::REQUIRED, 'The number of days before the return date.');
    }

    public function __construct(MailService $mailService, BookService $bookService, BorrowedBookService $borrowedBookService, ?string $name = null)
    {
        $this->mailService = $mailService;
        $this->bookService = $bookService;
        $this->borrowedBookService = $borrowedBookService;
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $numberDays = intval($input->getArgument('numberDays'));

        if ($numberDays === 0) {
            throw new InvalidArgumentException();
        }

        foreach ($this->borrowedBookService->getAllBorrowedBooks($numberDays) as $borrowedBook) {
            $this->mailService->sendMailRemindBorrower($borrowedBook);
        }
    }
}
