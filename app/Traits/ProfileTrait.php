<?php namespace Verein\Traits;

/**
 * This trait defines methods for the translated title and value.
 *
 * @property string $translationNamespace
 * @property string $title
 * @property string $value
 * @property bool $translatable
 */
trait ProfileTrait
{
	/**
	 * Get the translation of the title.
	 *
	 * @return string
	 */
	public function getTranslatedTitleAttribute()
	{
		$title = $this->translationNamespace . '.profile.title.' . strtolower(str_replace('.', '-', $this->title));

		return trans($title);
	}

	/**
	 * Returns the translation of the value if translatable is true. Otherwise returns the raw value.
	 *
	 * @return string
	 */
	public function getTranslatedValueAttribute()
	{
		$value = ($this->translatable)
			? trans($this->translationNamespace . '.profile.value.' . strtolower(str_replace('.', '-', $this->value)))
			: $this->value;

		return $value;
	}
}
