<?php

namespace FondOfSpryker\Zed\Jellyfish\Communication\Plugin;

use FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapperInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\Jellyfish\Dependency\Plugin\JellyfishCompanyBusinessUnitExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\Jellyfish\Business\JellyfishFacadeInterface getFacade()
 */
class JellyfishCompanyBusinessUnitCompanyExpanderPlugin extends AbstractPlugin implements JellyfishCompanyBusinessUnitExpanderPluginInterface
{
    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @var \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapperInterface
     */
    protected $jellyfishCompanyMapper;

    /**
     * @param \FondOfSpryker\Zed\Jellyfish\Dependency\Facade\JellyfishToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \FondOfSpryker\Zed\Jellyfish\Business\Model\Mapper\JellyfishCompanyMapperInterface $jellyfishCompanyMapper
     */
    public function __construct(
        JellyfishToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        JellyfishCompanyMapperInterface $jellyfishCompanyMapper
    ) {
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->jellyfishCompanyMapper = $jellyfishCompanyMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\JellyfishCompanyBusinessUnitTransfer
     */
    public function expand(JellyfishCompanyBusinessUnitTransfer $jellyfishCompanyBusinessUnitTransfer
    ): JellyfishCompanyBusinessUnitTransfer
    {

        if ($jellyfishCompanyBusinessUnitTransfer->getId() === null) {
            return $jellyfishCompanyBusinessUnitTransfer;
        }

        $companyBusinessUnitTransfer = $this->companyBusinessUnitFacade->getCompanyBusinessUnitById(
            (new CompanyBusinessUnitTransfer())
                ->setIdCompanyBusinessUnit($jellyfishCompanyBusinessUnitTransfer->getId())
        );

        $jellyfishCompanyTransfer = $this->jellyfishCompanyMapper
            ->fromCompany($companyBusinessUnitTransfer->getCompany());

        $jellyfishCompanyBusinessUnitTransfer->setCompany($jellyfishCompanyTransfer);

        return $jellyfishCompanyBusinessUnitTransfer;
    }
}
