<?php
namespace MarkShust\HierarchyComplexIdCompatibility\Model\VersionsCms\Hierarchy;

use \Exception;
use Magento\Framework\Message\ManagerInterface as MessageManager;

class Node extends \Magento\VersionsCms\Model\Hierarchy\Node
{
    /** @var MessageManager */
    protected $messageManager;

    /**
     * Node constructor.
     * @param MessageManager $messageManager
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\VersionsCms\Helper\Hierarchy $cmsHierarchy
     * @param \Magento\VersionsCms\Model\Hierarchy\ConfigInterface $hierarchyConfig
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\VersionsCms\Model\ResourceModel\Hierarchy\Node $resource
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\VersionsCms\Model\Hierarchy\NodeFactory $nodeFactory
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        MessageManager $messageManager,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\VersionsCms\Helper\Hierarchy $cmsHierarchy,
        \Magento\VersionsCms\Model\Hierarchy\ConfigInterface $hierarchyConfig,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\VersionsCms\Model\ResourceModel\Hierarchy\Node $resource,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\VersionsCms\Model\Hierarchy\NodeFactory $nodeFactory,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->messageManager = $messageManager;
        parent::__construct($context, $registry, $cmsHierarchy, $hierarchyConfig, $scopeConfig, $resource, $storeManager, $systemStore, $nodeFactory, $resourceCollection, $data);
    }

    /**
     * Recursive save nodes
     *
     * @param array $nodes
     * @param int $parentNodeId
     * @param string $path
     * @param string $xpath
     * @param int $level
     * @return $this
     * @throws Exception
     */
    protected function _collectTree(array $nodes, $parentNodeId, $path = '', $xpath = '', $level = 0)
    {
        if (!isset($nodes[$level])) {
            return $this;
        }
        foreach ($nodes[$level] as $k => $v) {
            $v['parent_node_id'] = $parentNodeId;

            if ($path != '' && strpos($v['request_url'], '/') === false) {
                $v['request_url'] = $path . '/' . $v['request_url'];
            }

            try {
                if ($this->isRequestUrlInTree($nodes, $v)) {
                    throw new Exception(__('The request URL <b>%1</b> already exists in node tree. Hierarchy not saved.', $v['request_url']));
                }
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e);
            }

            if ($xpath != '') {
                $v['xpath'] = $xpath . '/';
            } else {
                $v['xpath'] = '';
            }

            $object = clone $this;
            $object->setData($v)->save();

            if (isset($nodes[$k])) {
                $this->_collectTree($nodes, $object->getId(), $object->getRequestUrl(), $object->getXpath(), $k);
            }
        }
        return $this;
    }

    /**
     * Check if the current node request_url is already in the tree
     *
     * @param array $nodes
     * @param $currentNode
     * @return bool
     */
    public function isRequestUrlInTree(array $nodes, $currentNode)
    {
        foreach ($nodes as $parentNode) {
            foreach ($parentNode as $node) {
                if ($node['node_id'] !== $currentNode['node_id']
                    && $node['request_url'] === $currentNode['request_url']
                ) {
                    return true;
                }
            }
        }

        return false;
    }
}
