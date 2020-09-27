<?php


namespace App\Notification;

use App\Entity\Comment;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;

class CommentAcceptedNotification extends Notification implements EmailNotificationInterface
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;

        parent::__construct('Your comment has been published');
    }

    public function asEmailMessage(Recipient $recipient, string $transport = null): ?EmailMessage
    {
        $message = EmailMessage::fromNotification($this, $recipient, $transport);
        $message->getMessage()
            ->htmlTemplate('emails/comment_accepted.html.twig')
            ->context(['comment' => $this->comment])
        ;

        return $message;
    }

    public function getChannels(Recipient $recipient): array
    {
        $this->importance(Notification::IMPORTANCE_LOW);

        return ['email'];
    }
}