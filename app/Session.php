<?php namespace Verein;

use Illuminate\Database\Eloquent\Model;

use GeoIp2\Database\Reader;
use Jenssegers\Agent\Agent;

/**
 * Model for session data.
 *
 * @property string id
 * @property int user_id
 * @property string ip_address
 * @property string user_agent
 * @property string payload
 * @property string last_activity
 *
 * @property User $user
 */
class Session extends Model
{
	/**
	 * Sessions do not have auto increment keys.
	 *
	 * @var boolean
	 */
	public $incrementing = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sessions';

	/**
	 * Information about the user agent.
	 *
	 * @var Jenssegers\Agent\Agent
	 */
	protected $agent = null;

	/**
	 * Country code of the ip address.
	 *
	 * @var string
	 */
	protected $countryCode = null;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'last_activity',
	];

	/**
	 * Parse the user agent and stores it.
	 *
	 * @return void
	 */
	protected function parseUserAgent()
	{
		$this->agent = new Agent;
		$this->agent->setUserAgent($this->user_agent);
	}

	/**
	 * Get the user who owns the session.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo('\Verein\User');
	}

	/**
	 * Get the plaform from the user agent.
	 *
	 * @return string
	 */
	public function getPlatformAttribute()
	{
		if (empty($this->agent))
			$this->parseUserAgent();

		return $this->agent->platform();
	}

	/**
	 * Get the browser from the user agent.
	 *
	 * @return string
	 */
	public function getBrowserAttribute()
	{
		if (empty($this->agent))
			$this->parseUserAgent();

		return $this->agent->browser();
	}

	/**
	 * Get the browser version from the user agent.
	 *
	 * @return string
	 */
	public function getBrowserVersionAttribute()
	{
		if (empty($this->agent))
			$this->parseUserAgent();

		return $agent->version($this->browser);
	}

	/**
	 * Return the ISO3166 country code for the ip address.
	 *
	 * @return string
	 */
	public function getCountryCodeAttribute()
	{
		if ($this->countryCode !== null)
			return $this->countryCode;

		$reader = new Reader(storage_path('geoip/GeoLite2-Country.mmdb'));

		try {
			$record = $reader->country($this->ip_address);
			$this->countryCode = $record->country->isoCode;
		} catch (\GeoIp2\Exception\AddressNotFoundException $exception) {
			$this->countryCode = 'de';
		}

		return $this->countryCode;
	}
}
