<?php

class WC_Vipps_Agreement_Pricing extends WC_Vipps_Model {
	const TYPE_LEGACY = "LEGACY";
	const TYPE_VARIABLE = "VARIABLE";

	protected array $valid_types = [
		self::TYPE_LEGACY,
		self::TYPE_VARIABLE
	];

	protected array $required_fields = [
		"VARIABLE" => [ "type", "currency", "suggested_max_amount" ],
		"LEGACY"   => [ "type", "currency", "amount" ],
	];

	private string $type;
	private string $currency;
	private int $amount;
	private int $suggested_max_amount;
	private int $max_amount;

	/**
	 * @throws WC_Vipps_Recurring_Invalid_Value_Exception
	 */
	public function set_type( string $type ): self {
		if ( ! in_array( $type, $this->valid_types ) ) {
			$class = get_class( $this );
			throw new WC_Vipps_Recurring_Invalid_Value_Exception( "$type is not a valid value for `type` in $class." );
		}

		$this->type = $type;

		return $this;
	}

	public function set_currency( string $currency ): self {
		$this->currency = $currency;

		return $this;
	}

	public function set_amount( int $amount ): self {
		$this->amount = $amount;

		return $this;
	}

	public function set_suggested_max_amount( int $suggested_max_amount ): self {
		$this->suggested_max_amount = $suggested_max_amount;

		return $this;
	}

	public function set_max_amount( int $max_amount ): self {
		$this->max_amount = $max_amount;

		return $this;
	}

	/**
	 * @throws WC_Vipps_Recurring_Missing_Value_Exception
	 */
	function to_array(): array {
		$this->check_required( $this->type );

		return [
			"type"     => $this->type,
			"currency" => $this->currency,
			...$this->conditional( "amount", $this->amount ),
			...$this->conditional( "suggestedMaxAmount", $this->suggested_max_amount ),
			...$this->conditional( "maxAmount", $this->max_amount ),
		];
	}
}
