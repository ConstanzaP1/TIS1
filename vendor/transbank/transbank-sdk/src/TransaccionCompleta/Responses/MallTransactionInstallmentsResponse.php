<?php

namespace Transbank\TransaccionCompleta\Responses;

use Transbank\Utils\Utils;

class MallTransactionInstallmentsResponse
{
    public $installmentsAmount;
    public $idQueryInstallments;
    public $deferredPeriods;

    public function __construct($json)
    {
        $this->installmentsAmount = Utils::returnValueIfExists($json, 'installments_amount');
        $this->idQueryInstallments = Utils::returnValueIfExists($json, 'id_query_installments');
        $this->deferredPeriods = Utils::returnValueIfExists($json, 'deferred_periods');
    }

    /**
     * @return mixed
     */
    public function getInstallmentsAmount()
    {
        return $this->installmentsAmount;
    }

    /**
     * @param mixed $installmentsAmount
     */
    public function setInstallmentsAmount($installmentsAmount)
    {
        $this->installmentsAmount = $installmentsAmount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdQueryInstallments()
    {
        return $this->idQueryInstallments;
    }

    /**
     * @param mixed $idQueryInstallments
     */
    public function setIdQueryInstallments($idQueryInstallments)
    {
        $this->idQueryInstallments = $idQueryInstallments;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeferredPeriods()
    {
        return $this->deferredPeriods;
    }

    /**
     * @param mixed $deferredPeriods
     */
    public function setDeferredPeriods($deferredPeriods)
    {
        $this->deferredPeriods = $deferredPeriods;

        return $this;
    }
}
