<?php

namespace Inchoo\NewsWithComments\Block;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
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
     * @var FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var \Magento\Framework\Api\Search\FilterGroupBuilder
     */
    private $filterGroupBuilder;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    public function __construct(
        Template\Context $context,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository,
        \Inchoo\NewsWithComments\Api\CommentsRepositoryInterface $commentsRepository,
        \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory $newsModelFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\Session $session,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->newsRepository = $newsRepository;
        $this->commentsRepository = $commentsRepository;
        $this->newsModelFactory = $newsModelFactory;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->customerRepository = $customerRepository;
        $this->session = $session;
    }

    public function searchFilters($id)
    {
        $filter = $this->filterBuilder->create();
        $filter->setField('news');
        $filter->setValue($id);
        $filter->setConditionType('eq');

        $filter1 = $this->filterBuilder->create();
        $filter1->setField('comments_published');
        $filter1->setValue(true);
        $filter1->setConditionType('eq');

        $this->filterGroupBuilder->addFilter($filter);
        $filterGroup = $this->filterGroupBuilder->create();

        $this->filterGroupBuilder->addFilter($filter1);
        $filterGroup1 = $this->filterGroupBuilder->create();

        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchCriteria->setFilterGroups([$filterGroup, $filterGroup1]);

        return $searchCriteria;
    }

    public function isLoggedIn()
    {
        return $this->session->isLoggedIn();
    }

    public function getSaveAction()
    {
        return $this->getUrl('news/comment/save');
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
