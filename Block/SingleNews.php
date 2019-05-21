<?php

namespace Inchoo\NewsWithComments\Block;

use Inchoo\NewsWithComments\Api\Data\CommentsInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\View\Element\Template;

class SingleNews extends Template
{
    /**
     * @var \Inchoo\NewsWithComments\Api\NewsRepositoryInterface
     */
    private $newsRepository;
    /**
     * @var \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface
     */
    private $commentsRepository;
    /**
     * @var \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory
     */
    private $newsModelFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;
    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    private $redirect;

    public function __construct(
        Template\Context $context,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository,
        \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface $commentsRepository,
        \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory $newsModelFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        SortOrderBuilder $sortOrderBuilder,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->newsRepository = $newsRepository;
        $this->commentsRepository = $commentsRepository;
        $this->newsModelFactory = $newsModelFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->customerRepository = $customerRepository;
        $this->session = $session;
        $this->scopeConfig = $scopeConfig;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->redirect = $redirect;
    }

    public function searchFilters($id)
    {
        $sortOrder = $this->sortOrderBuilder->create();
        $sortOrder->setField(CommentsInterface::COMMENT_ID);
        $sortOrder->setDirection('DESC');

        $this->searchCriteriaBuilder->addFilter(CommentsInterface::COMMENTS_KEY, $id, 'eq');
        $this->searchCriteriaBuilder->addFilter(CommentsInterface::PUBLISHED, true, 'eq');
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $searchCriteria;
    }

    public function isEnabled()
    {
        return (bool)$this->scopeConfig->getValue('newswithcomments/general/enable');
    }

    public function isLoggedIn()
    {
        return $this->session->isLoggedIn();
    }

    public function getSaveAction()
    {
        return $this->getUrl('news/comment/save');
    }

    public function getLoginUrl()
    {
        $url = $this->redirect->getRefererUrl();
        return $this->getUrl('customer/account/login', ['referer' => base64_encode($url)]);
    }

    public function getAuthorName($id)
    {
        $author = $this->customerRepository->getById($id);
        return $user =$author->getFirstname() . " " . $author->getLastname();
    }

    public function getSingleNews()
    {
        $newsId = $this->_request->getParam('id');
        $searchCriteria = $this->searchFilters($newsId);

        $news = $this->newsRepository->getById($newsId);

        $comments = $this->commentsRepository->getList($searchCriteria);

        foreach ($comments->getItems() as $comment) {
            $comment->setAuthor($this->getAuthorName($comment->getAddedBy()));
        }

        $news->setComments($comments->getItems());

        return $news;
    }
}
