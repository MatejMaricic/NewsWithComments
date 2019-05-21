<?php

namespace Inchoo\NewsWithComments\Controller\Adminhtml\News;

use Inchoo\NewsWithComments\Api\Data\NewsInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

class Save extends Action
{
    protected $_request;
    /**
     * @var \Inchoo\NewsWithComments\Model\NewsRepository
     */
    private $newsRepository;
    /**
     * @var \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory
     */
    private $newsModelFactory;
    /**
     * @var \Magento\Framework\Escaper
     */
    private $_escaper;
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    private $authSession;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Inchoo\NewsWithComments\Api\NewsRepositoryInterface $newsRepository,
        \Inchoo\NewsWithComments\Api\Data\NewsInterfaceFactory $newsModelFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Escaper $_escaper,
        \Magento\Backend\Model\Auth\Session $authSession
    ) {
        $this->_request = $request;
        parent::__construct($context);
        $this->newsRepository = $newsRepository;
        $this->newsModelFactory = $newsModelFactory;
        $this->messageManager = $messageManager;
        $this->_escaper = $_escaper;
        $this->authSession = $authSession;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(NewsInterface::ADMIN_RESOURCE);
    }

    protected function getCurrentUser()
    {
        return $this->authSession->getUser()->getId();
    }
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $data = $this->_request->getParams();
        $data['admin_id'] = $this->getCurrentUser();
        foreach ($data as $key => $value) {
            $data[$key] = $this->_escaper->escapeHtml($value);
        }
        if ($data) {
            $status = $this->newsRepository->updateNews($data);
            if ($status === true) {
                $this->messageManager->addSuccessMessage('News added');
                return $this->_redirect('news/news');
            } else {
                $message = $status;
                $this->messageManager->addErrorMessage($message);
                return $this->_redirect('news/news/new');
            }
        }
    }
}
