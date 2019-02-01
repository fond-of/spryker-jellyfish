<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter;

use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCustomerMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCustomerFacadeInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Shared\Log\LoggerTrait;

class CustomerExporter implements ExporterInterface
{
    use LoggerTrait;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCustomerFacadeInterface
     */
    protected $customerFacade;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCustomerMapperInterface
     */
    protected $jellyfishCustomerMapper;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCustomerFacadeInterface $customerFacade
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCustomerMapperInterface $jellyfishCustomerMapper
     *
     */
    public function __construct(
        JellyfishToCustomerFacadeInterface $customerFacade,
        JellyfishCustomerMapperInterface $jellyfishCustomerMapper
    ) {
        $this->customerFacade = $customerFacade;
        $this->jellyfishCustomerMapper = $jellyfishCustomerMapper;
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface[] $transfers
     *
     * @return void
     */
    public function exportBulk(array $transfers): void
    {
        foreach ($transfers as $transfer) {
            if (!$this->canExport($transfer)) {
                continue;
            }

            $this->exportById($transfer->getId());
        }
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     *
     * @return bool
     */
    protected function canExport(TransferInterface $transfer): bool
    {
        return $transfer instanceof EventEntityTransfer &&
            count($transfer->getModifiedColumns()) > 0 &&
            $transfer->getName() === 'spy_customer';
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function exportById(int $id): void
    {
        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setIdCustomer($id);

        $customerTransfer = $this->customerFacade->findCustomerById($customerTransfer);

        $jellyfishCustomerTransfer = $this->jellyfishCustomerMapper->fromCustomer($customerTransfer);
        $this->getLogger()->error($jellyfishCustomerTransfer->serialize());
    }
}
