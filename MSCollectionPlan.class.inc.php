<?php

class MSCollectionPlan
{
	// List of objects that can be used within requests
	protected $aMSObjectsToConsider = [];

	// Instance of the collection plan
	static protected $oMSCollectionPlan;

	public function __construct()
	{
		self::$oMSCollectionPlan = $this;
	}

	/**
	 * @return \MSCollectionPlan
	 */
	public static function GetPlan()
	{
		return self::$oMSCollectionPlan;
	}

	/**
	 * Tells if a collector need to be orchestrated or not
	 *
	 * @param $sCollectorClass
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function CollectorToBeLaunched($sCollectorClass): bool
	{
		return true;
	}

	/**
	 * Enrich the list of objects that can be considered during collections
	 *
	 * @param $sObjectL1 : URI_PARAM_SUBSCRIPTION or URI_PARAM_GROUP
	 * @param $sObjectL2 : URI_PARAM_RESOURCEGROUP
	 * @param $sObjectL3 : URI_PARAM_SERVER ou URI_PARAM_VNET
	 *
	 * @return void
	 */
	public function AddMSObjectsToConsider($sObjectL1, $sObjectL2, $sObjectL3)
	{
		if ($sObjectL1 != null) {
			if (!array_key_exists($sObjectL1, $this->aMSObjectsToConsider)) {
				$this->aMSObjectsToConsider[$sObjectL1] = [];
			}
			if ($sObjectL2 != null) {
				if (!array_key_exists($sObjectL2, $this->aMSObjectsToConsider[$sObjectL1])) {
					$this->aMSObjectsToConsider[$sObjectL1][$sObjectL2] = [];
				}
				if ($sObjectL3 != null) {
					if (!array_key_exists($sObjectL3, $this->aMSObjectsToConsider[$sObjectL1][$sObjectL2])) {
						$this->aMSObjectsToConsider[$sObjectL1][$sObjectL2][$sObjectL3] = [];
					}
				}
			}
		}
	}

	/**
	 * Provide the list of objects to consider during the collection
	 *
	 * @return array|\string[][][]
	 */
	public function GetMSObjectsToConsider(): array
	{

		return $this->aMSObjectsToConsider;
	}

	/**
	 * Is there any subscription to consider in the  collection plan ?
	 *
	 * @return bool
	 */
	protected function IsSubscriptionToConsider(): bool
	{
		return (empty($this->aMSObjectsToConsider) ? false : true);
	}

	/**
	 * Is there any resource group to consider during the collection ?
	 *
	 * @return bool
	 */
	protected function IsResourceGroupToConsider(): bool
	{
		foreach ($this->aMSObjectsToConsider as $sSubscription => $aResourceGroup) {
			if (!empty($aResourceGroup)) {
				return true;
			}
		}

		return false;
	}
}
