<?php

namespace Inchoo\NewsWithComments\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Index extends Action
{


    /**
     * @var \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory
     */
    private $newsModelFactory;
    /**
     * @var \Inchoo\NewsWithComments\Api\Data\CommentsInterfaceFactory
     */
    private $commentsModelFactory;
    /**
     * @var \Inchoo\NewsWithComments\Api\NewsRepositoryInterface
     */
    private $newsRepository;
    /**
     * @var \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface
     */
    private $commentsRepository;


    public function __construct(
        Context $context,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository,
        \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface $commentsRepository,
        \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory $newsModelFactory,
        \Inchoo\NewsWithComments\Api\Data\CommentsInterfaceFactory $commentsModelFactory
    ) {
        parent::__construct($context);
        $this->newsModelFactory = $newsModelFactory;
        $this->commentsModelFactory = $commentsModelFactory;
        $this->newsRepository = $newsRepository;
        $this->commentsRepository = $commentsRepository;
    }

    public function execute()
    {
        $items = $this->_request->getParams();
        var_dump($items);
//        $news = $this->newsModelFactory->create();
//        $news->setTitle('Test');
//        $news->setContent('content');
//        $news->setAddedBy(1);
//        $this->newsRepository->save($news);
//
//        $comment = $this->commentsModelFactory->create();
//        $comment->setContent('neki komentar');
//        $comment->setAddedBy(2);
//        $comment->setForeignKey($news->getId());
//        $this->commentsRepository->save($comment);


    }
}
