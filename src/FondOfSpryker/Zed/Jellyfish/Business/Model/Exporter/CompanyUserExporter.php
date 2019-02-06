<?php

namespace FondOfSpryker\Zed\Jellyfish\Business\Model\Exporter;

use FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface;
use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUserMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUserFacadeInterface;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Shared\Log\LoggerTrait;

class CompanyUserExporter implements ExporterInterface
{
    use LoggerTrait;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUserFacadeInterface $companyUserFacade
     */
    protected $companyUserFacade;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUserMapperInterface $jellyfishCompanyUserMapper
     */
    protected $jellyfishCompanyUserMapper;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyUserMapperInterface $jellyfishCompanyUserMapper
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Api\Adapter\AdapterInterface $adapter
     */
    public function __construct(
        JellyfishToCompanyUserFacadeInterface $companyUserFacade,
        JellyfishCompanyUserMapperInterface $jellyfishCompanyUserMapper,
        AdapterInterface $adapter
    ) {
        $this->companyUserFacade = $companyUserFacade;
        $this->jellyfishCompanyUserMapper = $jellyfishCompanyUserMapper;
        $this->adapter = $adapter;
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
            $transfer->getName() === 'spy_company_user';
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function exportById(int $id): void
    {
        $companyUser = $this->companyUserFacade->getCompanyUserById($id);

        $jellyfishCompanyUserTransfer = $this->jellyfishCompanyUserMapper->fromCompanyUser($companyUser);

        $this->adapter->sendRequest($jellyfishCompanyUserTransfer);
    }
}
