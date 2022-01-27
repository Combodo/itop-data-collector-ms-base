<?php

class MSCollectionPlan
{
	static protected $oMSCollectionPlan;
	private $aMSObjectsToConsider = [];

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
	 * Enrich the list of objects that can be oncsidered during collections
	 *
	 * @param $sObjectL1
	 * @param $sObjectL2
	 * @param $sObjectL3
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
	 * Provide the list of resource group to consider during the collection
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
	private function IsSubscriptionToConsider(): bool
	{
		return (empty($this->aMSObjectsToConsider) ? false : true);
	}

	/**
	 * Is there any resource group to consider during the collection ?
	 *
	 * @return bool
	 */
	private function IsResourceGroupToConsider(): bool
	{
		foreach ($this->aMSObjectsToConsider as $sSubscription => $aResourceGroup) {
			if (!empty($aResourceGroup)) {
				return true;
			}
		}

		return false;
	}
}
